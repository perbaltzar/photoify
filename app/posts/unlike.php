<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (is_logged_in() && isset($_GET['post_id'])){
  $user_id = (int)$_SESSION['user']['id'];
  $post_id = (int) $_GET['post_id'];
  $redirect = $_GET['redirect'];


  // Check if like already excist in Database
  $statement = $pdo->prepare('DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $statement->execute();
}
redirect("/$redirect?post_id=$post_id");
