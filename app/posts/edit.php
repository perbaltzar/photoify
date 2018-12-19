<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_SESSION['user'], $_GET['post_id'], $_POST['description']))
{
  $post_id = (int)$_GET['post_id'];
  $user_id = (int)$_SESSION['user']['id'];
  $description = $_POST['description'];
  $updated_at = date("Y-m-d");

  // die(var_dump($post_id,$user_id));

  $statement = $pdo->prepare('UPDATE posts SET description = :description, updated_at = :updated_at WHERE user_id = :user_id AND id = :post_id');
  if (!$statement){
    die(var_dump($pdo->errorInfo()));
  }
  $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->bindParam(':description', $description, PDO::PARAM_STR);
  $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
  $statement->execute();

}else{
  $_SESSION['error'] = 'You\'re Not Logged In';
}
redirect('/feed.php');
