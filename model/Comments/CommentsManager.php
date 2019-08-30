<?php

namespace model\Comments;
use model\PDOFactory;

class CommentsManager extends PDOFactory
{
    public function getComments()
    {
        $db = $this->getMysqlConnexion();
        $query = $db->query('SELECT id, author, comment, DATE_FORMAT(creation_date, \'%d/%m/%Y à %H:%i\') AS creation_date_fr FROM comments ORDER BY creation_date DESC');
        return $query;
    }

    public function getNotifiedComments()
    {
        $db = $this->getMysqlConnexion();
        $query = $db->query('SELECT author, comment, comment_id, DATE_FORMAT(notify_date, \'%d/%m/%Y à %H:%i\') AS notify_date_fr FROM notifiedcomments ORDER BY notify_date DESC');
        return $query;
    }

    public function notifyComment($id)
    {
        $db = $this->getMysqlConnexion();
        $query = $db->prepare('SELECT author, comment FROM comments WHERE id = :id');
        $query->execute(["id" => $id]);
        return $query->fetch();
    }

    public function addNotifiedComment($commentId, $author, $comment)
    {
        $db = $this->getMysqlConnexion();
        $reportedComment = $db->prepare('INSERT INTO notifiedcomments(comment_id, author, comment, notify_date) VALUES(:comment_id, :author, :comment, NOW())');
        $affectedLines = $reportedComment->execute(['comment_id' => $commentId, 'author' => $author, 'comment' => $comment]);
        return $affectedLines;
    }

    public function postComment($author, $comment)
    {
        $db = $this->getMysqlConnexion();
        $addedComment = $db->prepare('INSERT INTO comments(author, comment, creation_date) VALUES(:author, :comment, NOW())');
        $affectedLines = $addedComment->execute(['author' => $author, 'comment' => $comment]);
        return $affectedLines;
    }

    public function deleteComment($commentId)
    {
        $db = $this->getMysqlConnexion();
        $db->exec("DELETE FROM comments WHERE id=$commentId");
    }
}