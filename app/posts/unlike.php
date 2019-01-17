<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Check if user is logged in
if (!is_logged_in())
{
  $_SESSION['error'] = "Please log in and try again!";
  redirect('/');
}

if (isset($_POST['post_id'])){
  $user_id = (int) $_SESSION['user']['id'];
  $post_id = (int) filter_var($_POST['post_id'], FILTER_VALIDATE_INT);


  // Check if like already excist in Database
  $statement = $pdo->prepare('DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $statement->execute();
  
  $likes = count_likes($post_id, $pdo);
  $likes = json_encode($likes);
  header ('Content-Type: application/json');
  echo $likes;
}

