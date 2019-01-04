<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';


if (is_logged_in()){
  $id = (int) $_SESSION['user']['id'];
  // die(var_dump($id));
  // Deleting the user, comments, follows, likes and posts from the database
  $statement = $pdo->prepare('DELETE FROM users WHERE id = :id');
  if (!$statement){
    die(var_dump($pdo->errorInfo()));
  }
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();

  $statement = $pdo->prepare('DELETE FROM posts WHERE user_id = :id');
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();

  $statement = $pdo->prepare('DELETE FROM followers WHERE user_id = :id OR follower_id = :id');
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();

  $statement = $pdo->prepare('DELETE FROM comments WHERE user_id = :id');
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();

  $statement = $pdo->prepare('DELETE FROM likes WHERE user_id = :id');
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();

}

session_destroy();
redirect('login.php');
