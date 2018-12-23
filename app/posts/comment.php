<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (is_logged_in() && isset($_POST['comment'], $_GET['post_id'])){
  $redirect = $_GET['redirect'];
  $user_id = (int) $_SESSION['user']['id'];
  $content = $_POST['comment'];
  $post_id = (int) $_GET['post_id'];
  $created_at = date("Y-m-d");

  $statement = $pdo->prepare(
    'INSERT INTO comments (post_id, user_id, content, created_at)
    VALUES (:post_id, :user_id, :content, :created_at)'
  );

  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $statement->bindParam(':content', $content, PDO::PARAM_STR);
  $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
  $statement->execute();


}
redirect("/$redirect?post_id=$post_id");
