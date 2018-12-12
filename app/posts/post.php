<?php

declare(strict_types=1);
require __DIR__.'/../../views/header.php';

if (isset($_POST['description'], $_FILES['content'])){
  $post = $_FILES['content'] ;
  // die(var_dump($post));

// Checking file types and size
  if ($post['type'] === 'image/jpeg'){
    if ($post['size'] < 3000000){
      $_SESSION['user']['id'];



      // Creating a directory for user in upload if ont excists
      if (!file_exists(__DIR__.'/../uploads/'.$_SESSION['user']['id'])) {
        mkdir(__DIR__.'/../uploads/'.$_SESSION['user']['id'], 0777, true);
      }


      // Moving content to post folder
      $postName = "/../uploads/".$_SESSION['user']['id'].'/'.time().'-'.$post['name'];
      move_uploaded_file($post['tmp_name'], __DIR__.$postName);

      // Changing path for Database
      $postName = "/app/uploads/".$_SESSION['user']['id'].'/'.time().'-'.$post['name'];
      $created_at = date("Y-m-d H:i:s");

      // Saving Information in Database
      $statement = $pdo->prepare(
        'INSERT INTO posts (user_id, content, description, created_at)
         VALUES (:user_id, :content, :description, :created_at);'
       );
      $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
      $statement->bindParam(':content', $postName, PDO::PARAM_STR);
      $statement->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
      $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
      $statement->execute();

      // if (!$statement){
        // die(var_dump($statement->errorInfo()));
      // }


      redirect('/post.php');

    }else{
      echo 'The uploaded file exceeded the file size limit.';
    }
  }else{
    echo 'The image file type is not allowed.';
  }
}
die;
redirect('/post.php');





?>
