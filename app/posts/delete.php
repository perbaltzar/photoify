<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_SESSION['user'], $_GET['post_id']))
{
  $post_id = (int)$_GET['post_id'];
  $user_id = (int)$_SESSION['user']['id'];

  $post = get_post_by_postid($post_id, $pdo);
  if ((int)$post['user_id']=== $user_id){
    $path = '/../../assets/uploads/'.$post['content'];
    unlink(__DIR__.$path);
    // unlink();
  }
  
  $statement = $pdo->prepare('DELETE FROM posts WHERE user_id = :user_id AND id = :post_id');
  if (!$statement){
    die(var_dump($pdo->errorInfo()));
  }
  $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();

}else{
  $_SESSION['error'] = 'You\'re Not Logged In';
}
redirect('/');
