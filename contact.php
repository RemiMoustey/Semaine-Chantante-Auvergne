<?php
$subject = $_POST['subject'];
$email = $_POST['email'];
$message = $_POST['message'];
$headers = "FROM: $email";

mail('remimoustey@gmail.com', $subject, $message, $headers);