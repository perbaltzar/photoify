<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (is_logged_in() && isset($_GET['post_id'])){
  $user_id = (int)$_SESSION['user']['id'];
  $created_at = date("Y-m-d");
  $post_id = (int) $_GET['post_id'];


  // Check if like allready excist in Database
  $statement->prepare('SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $statement->execute();
  $check_for_like = $






  $statement = $pdo->prepare('INSERT INTO likes(post_id,
    user_id, created_at) VALUES(:post_id, :user_id, :created_at)');
    if (!$statement){
      die(var_dump($pdo->errorInfo()));
    }
  $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
  $statement->execute();

}
redirect('/feed.php');
