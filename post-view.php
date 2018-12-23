<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in() && isset($_GET['post_id'])){
  $post_id = $_GET['post_id'];
  // Collecting data from database, tables users and posts
  $statement = $pdo->prepare(
    "SELECT p.id as post_id, p.content, p.description, p.created_at, p.created_at,
    u.username, u.id as user_id, u.profile_picture
    FROM posts p INNER JOIN users u WHERE u.id = p.user_id AND p.id = :post_id"
    );
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  // Saving database in variable
  $post = $statement->fetch(PDO::FETCH_ASSOC);

  
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <center>
    <img style="width: 30px; height: 30px;" src="<?='/assets/uploads/'.$post['profile_picture']?>">
    <?php if (is_owner($post['user_id'], $_SESSION['user']['id'])): ?>
      <a href="profile-home.php"><?=$post['username'];?>:</a><br>
    <?php else: ?>
      <a href="profile-guest.php?profile_id=<?=$post['user_id'];?>"><?=$post['username'];?>:</a><br>
    <?php endif; ?>

    <img style="width: 150px; height: 150px;" src="<?='/assets/uploads/'.$post['content']?>">
    <br>
    <p><?=$post['description'];?></p>
    <br>
    <?php
    // Counting the rows in likes table
    $statement = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE post_id = :post_id');
    $id = $post['post_id'];
    $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
    $statement->execute();
    $likes = $statement->fetch(PDO::FETCH_ASSOC);
    $likes = $likes["COUNT(*)"];
    ?>
    Number of likes: <?=$likes?><br>
    <?php
    // If post is by current user
    // Putting out edit and delete
    if (is_owner($post['user_id'], $_SESSION['user']['id'])): ?>
    <a href="app/posts/delete.php?post_id=<?=$post['id']?>">Delete this post</a>
    <a href="post-edit.php?post_id=<?=$post['id']?>">Edit this post</a>
    <br>
    <?php
    // If post is not by current user
    // Putting out like and unlike
    else: ?>
      <a href="app/posts/like.php?post_id=<?=$post['post_id'];?>">Like</a>
      <a href="app/posts/unlike.php?post_id=<?=$post['post_id'];?>">Unlike</a>
      <br><br><br>
      <br>
    <?php endif; ?>


  </center>
  </body>
</html>
