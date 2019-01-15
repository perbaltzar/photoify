<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Check if user is logged in
if (!is_logged_in())
{
  $_SESSION['error'] = 'You\'re Not Logged In';
  redirect('/');
}

// IF PASSWORD CHECK!
  $id = (int) $_SESSION['user']['id'];
  
  // Deleting the users uploaded files 
 if ($_SESSION['user']['profile_picture'] !== 'default-profile.jpg')
 {
   unlink(__DIR__.'/../../assets/uploads/'.$_SESSION['user']['profile_picture']);
 }
 $posts = get_posts_by_userid($id, $pdo);
 foreach ($posts as $post) {
   unlink(__DIR__.'/../../assets/uploads/'.$post['content']);
 }

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



session_destroy();
redirect('/');

