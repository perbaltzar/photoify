<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_POST['message'], $_POST['profile_id'])){
    $message = $_POST['message'];
    $profile_id = (int) $_POST['profile_id'];
    $id = (int) $_SESSION['user']['id'];
    $created_at = date("Y-m-d");


    $statement = $pdo->prepare('INSERT INTO messages (to_id, from_id, content, created_at) 
    VALUES(:to_id, :id, :content, :created_at)');
    $statement->bindParam(':to_id', $profile_id, PDO::PARAM_INT);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':content', $message, PDO::PARAM_STR);
    $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    $statement->execute();

    redirect("/message.php?profile_id=$profile_id");
}
  