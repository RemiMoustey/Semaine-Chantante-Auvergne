<?php

namespace model\Comments;
define('PER_PAGE', 5);
use model\PDOFactory;

/**
 * Récupère des informations sur les commentaires postés dans la base de données et les organise
 * selon les besoins à la demande du contrôleur.
 * 
 * @author  Rémi Moustey <remimoustey@gmail.com>
 */
class CommentsManager extends PDOFactory
{
    /**
     * Sélectionne tous les commentaires dans la base de données.
     *
     * @return PDOStatement
     */
    public function getComments()
    {
        $db = $this->getMysqlConnexion();
        $page = (int)($_GET['p'] ?? 1);
        $offset = ($page - 1) * PER_PAGE;
        if ($offset < 0)
        {
            $offset = 0;
        }
        return $query = $db->query('SELECT id, author, comment, DATE_FORMAT(creation_date, \'%d/%m/%Y à %H:%i\') AS creation_date_fr FROM comments ORDER BY creation_date DESC LIMIT ' . PER_PAGE . " OFFSET $offset");
    }

    /**
     * Sélectionne tous les commentaires signalés dans la base de données.
     *
     * @return PDOStatement
     */
    public function getNotifiedComments()
    {
        $db = $this->getMysqlConnexion();
        $query = $db->query('SELECT author, comment, comment_id, DATE_FORMAT(notify_date, \'%d/%m/%Y à %H:%i\') AS notify_date_fr FROM notifiedcomments ORDER BY notify_date DESC');
        return $query;
    }

    /**
     * Sélectionne le commentaire que l'utilisateur a demandé à signaler.
     *
     * @param  string $id
     *
     * @return array
     */
    public function notifyComment($id)
    {
        $db = $this->getMysqlConnexion();
        $query = $db->prepare('SELECT author, comment FROM comments WHERE id = :id');
        $query->execute(["id" => $id]);
        return $query->fetch();
    }

    /**
     * Ajoute un commentaire signalé dans la table correspondante.
     *
     * @param  string $commentId
     * @param  string $author
     * @param  string $comment
     *
     * @return void
     */
    public function addNotifiedComment($commentId, $author, $comment)
    {
        $db = $this->getMysqlConnexion();
        $reportedComment = $db->prepare('INSERT INTO notifiedcomments(comment_id, author, comment, notify_date) VALUES(:comment_id, :author, :comment, NOW())');
        $reportedComment->execute(['comment_id' => $commentId, 'author' => $author, 'comment' => $comment]);
    }

    /**
     * Ajoute un commentaire posté par l'utilisateur.
     *
     * @param  string $author
     * @param  string $comment
     *
     * @return void
     */
    public function postComment($author, $comment)
    {
        $db = $this->getMysqlConnexion();
        $addedComment = $db->prepare('INSERT INTO comments(author, comment, creation_date) VALUES(:author, :comment, NOW())');
        $addedComment->execute(['author' => $author, 'comment' => $comment]);
    }

    /**
     * Supprime un commentaire des tables comments et notifiedcomments (grâce à l'option ON DELETE CASCADE)
     *
     * @param  string $commentId
     *
     * @return void
     */
    public function deleteComment($commentId)
    {
        $db = $this->getMysqlConnexion();
        $db->exec("DELETE FROM comments WHERE id=$commentId");
    }

    /**
     * Permet de compter le nombre de commentaires pour la pagination.
     *
     * @return PDOStatement
     */
    public function getNumberComments()
    {
        $db = $this->getMysqlConnexion();
        return $db->query('SELECT count(id) as count FROM comments');
    }
}