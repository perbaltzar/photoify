<?php

declare(strict_types=1);

require __DIR__.'/app/autoload.php';

 if (isset($_SESSION['user'], $_GET['post_id'])){
   $user_id = (int)$_SESSION['user']['id'];
   $post_id = (int)$_GET['post_id'];

   //Collecting data from database

   $statement = $pdo->prepare('SELECT * FROM posts WHERE user_id = :user_id AND id = :post_id');
   if (!$statement){
     die(var_dump($pdo->errorInfo()));
   }
   $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
   $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
   $statement->execute();
   $post = $statement->fetch(PDO::FETCH_ASSOC);
   // die(var_dump($post));
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Post</title>
  </head>
  <body>
    <?php if ($post): ?>
      <!-- Show picture here -->

      <form method="post" enctype="multipart/form-data" action="app/posts/edit.php?post_id=<?=$post['id']?>">
        <!-- <label for="uploadFiles">Choose a JPG image to upload</label> -->
        <label for="description">Edit your description</label>
        <textarea name="description"><?= $post['description'];?></textarea>
        <button type="submit">Save</button>
      </form>
    <?php else: ?>
        Couldn't find your post, please try again
    <?php endif; ?>
  </body>
</html>
