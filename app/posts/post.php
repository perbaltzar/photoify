<?php

declare(strict_types=1);
require __DIR__.'/../../views/header.php';

if (isset($_POST['description'], $_FILES['content'])){
  $post = $_FILES['content'] ;
  // die(var_dump($post));

// Checking file types and size
  if ($post['type'] === 'image/jpeg'){
    if ($post['size'] < 3000000){
      $id = (int) $_SESSION['user']['id'];



      // Creating a directory for user in upload if ont excists
      $path = makeDirPath($id, 'posts');
      if (!file_exists(__DIR__.$path)) {
        mkdir(__DIR__.$path, 0777, true);
      }
      // die(var_dump($path));
      // Moving content to post folder
      $postName = time().'-'.$post['name'];
      move_uploaded_file($post['tmp_name'], __DIR__.$path.$postName);

      // Changing path for Database
      $postPath = "/app/uploads/$id/posts/".$postName;
      $created_at = date("Y-m-d H:i:s");

      // Saving Information in Database
      $statement = $pdo->prepare(
        'INSERT INTO posts (user_id, content, description, created_at)
         VALUES (:user_id, :content, :description, :created_at);'
       );
      $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
      $statement->bindParam(':content', $postPath, PDO::PARAM_STR);
      $statement->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
      $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
      $statement->execute();
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
