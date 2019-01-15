<?php

declare(strict_types=1);
require __DIR__.'/../../views/header.php';

// Check if user is logged in
if (!is_logged_in())
{
  $_SESSION['error'] = 'You\'re Not Logged In';
  redirect('/');
}

if (isset($_FILES['content'])){
  $post = $_FILES['content'] ;
  // die(var_dump($post));

// Checking file types and size
  if ($post['type'] === 'image/jpeg' || $post['type'] === 'image/png' || $post['type'] === 'image/gif'){
    if ($post['size'] < 3000000){
      $id = (int) $_SESSION['user']['id'];
      $path = '/../../assets/uploads/';
      $post_name = time().'-'.$id.'-'.$post['name'];
      $created_at = date("Y-m-d H:i:s");

      move_uploaded_file($post['tmp_name'], __DIR__.$path.$post_name);


      // Saving Information in Database
      $statement = $pdo->prepare(
        'INSERT INTO posts (user_id, content, description, created_at)
         VALUES (:user_id, :content, :description, :created_at);'
      );
      $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
      $statement->bindParam(':content', $post_name, PDO::PARAM_STR);
      $statement->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
      $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
      $statement->execute();
      redirect('/post.php');

    }else{
      $_SESSION['error'] = 'The uploaded file exceeded the file size limit.';
    }
  }else{
    $_SESSION['error'] = 'The image file type is not allowed.';
  }
}
die;
redirect('/feed.php');





?>
