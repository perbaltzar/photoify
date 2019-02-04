<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';
// Check if user is logged in
if (!is_logged_in()) {
    $_SESSION['error'] = "Please log in and try again!";
    redirect('/');
}

if (isset($_POST['message'], $_POST['profile_id'], $_POST['conversation_id'])) {
    $message = $_POST['message'];
    $conversation_id = (int) $_POST['conversation_id'];
    $profile_id = (int) $_POST['profile_id'];
    $id = (int) $_SESSION['user']['id'];
    $created_at = date("Y-m-d");


    $statement = $pdo->prepare('INSERT INTO messages (sender_id, conversation_id, content, created_at) 
    VALUES(:sender_id, :conversation_id, :content, :created_at)');
    $statement->bindParam(':sender_id', $id, PDO::PARAM_INT);
    $statement->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
    $statement->bindParam(':content', $message, PDO::PARAM_STR);
    $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    $statement->execute();

    redirect("/message.php?profile_id=$profile_id");
}
