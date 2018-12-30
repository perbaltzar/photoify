<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

// Collecting data from Database
$statement = $pdo->prepare(
  "SELECT p.id as post_id, p.content, p.description, p.created_at, p.created_at,
  u.username, u.id as user_id, u.profile_picture
  FROM posts p INNER JOIN users u WHERE u.id = p.user_id"
);

$statement->execute();
// Saving database in variable
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

// Counting the rows in likes table
$statement = $pdo->prepare('SELECT COUNT(*) FROM likes');
$statement->execute();
$likes = $statement->fetchAll(PDO::FETCH_ASSOC);
if (!$statement){
  die(var_dump($pdo->errorInfo()));
}
// die(var_dump($likes));

?>

  <?php
  //Looping through all the posts
  foreach ($posts as $post) :?>
  <?php
  // Counting the rows in likes table
  $statement = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE post_id = :post_id');
  $id = $post['post_id'];
  $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $likes = $statement->fetch(PDO::FETCH_ASSOC);
  $likes = $likes["COUNT(*)"];
  // Counting the comments in comment table
  $statement = $pdo->prepare('SELECT COUNT(*) FROM comments WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $comments = $statement->fetch(PDO::FETCH_ASSOC);
  $comments = $comments["COUNT(*)"];
  ?>

  <div class="feed-container">
    <div class="feed-avatar-container">
      <img class="feed-avatar" src="<?='/assets/uploads/'.$post['profile_picture']?>">
      <?php if (is_owner($post['user_id'], $_SESSION['user']['id'])): ?>
        <div class="feed-name-container">
          <a class="feed-avatar-link" href="profile-home.php"><?=$post['username'];?></a>
          <?=$post['created_at']?>
        </div>
      <?php else: ?>
        <div class="feed-name-container">
          <a class="feed-avatar-link" href="profile-guest.php?profile_id=<?=$post['user_id'];?>"><?=$post['username'];?></a>
          <?=$post['created_at']?>
        </div>
      <?php endif; ?>
    </div>
    <div class="feed-img-container">
    <a href="post-view.php?post_id=<?=$post['post_id'];?>">
      <img class="feed-img" src="<?='/assets/uploads/'.$post['content']?>">
    </a>
  </div>
    <div class="feed-button-container">
      <?=$likes?> likes -
      <?=$comments?> comments
      <a href="app/posts/like.php?post_id=<?=$post['post_id'];?>&redirect=index.php">
      <img class="feed-like"src="assets/icons/heart.svg">
      <!--
      link to unlike
      <a href="app/posts/unlike.php?post_id=<?=$post['post_id'];?>&redirect=index.php">Unlike</a>
      -->
    </a>

    </div>
    <div class="feed-description">
      <p><?=$post['description'];?></p>
    </div>

    <!-- Likebutton -->



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
  <br><br><br>
  <br>
<?php endif; ?>
</div>
<?php endforeach; ?>
<?php
require __DIR__.'/views/navbar.php';
?>
