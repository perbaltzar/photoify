<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

// Storing needed variables
$id = (int) $_SESSION['user']['id'];

// Collecting data from Database
$statement = $pdo->prepare(
  "SELECT p.id as post_id, p.content, p.description, p.created_at, p.updated_at,
  u.username, u.id as user_id, u.profile_picture
  FROM posts p INNER JOIN users u WHERE u.id = p.user_id"
);
$statement->execute();

// Saving database in variable and swiching them over so the latest post is put first
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
$posts = array_reverse($posts);


?>
<section class="all-feed-container">

  <?php
  // Looping through all the posts
  foreach ($posts as $post) :

  // Storing variables
  $post_id = (int)$post['post_id'];
  $poster_id = (int)$post['user_id'];

  $likes = count_likes($post_id, $pdo);
  $comments = count_comments($post_id, $pdo);
  $ago = get_time(time()-strtotime($post['created_at']));
  $is_liked_by_user = is_post_liked_by_user($id, $post_id, $pdo);
  ?>

  <div class="feed-container">
    <div class="feed-avatar-container">
      <img class="feed-avatar" src="<?='/assets/uploads/'.$post['profile_picture']?>">
      <?php if (is_owner($poster_id, $id)): ?>
        <div class="feed-name-container">
          <a class="feed-avatar-link" href="profile-home.php"><?=$post['username'];?></a>
          <?=$ago?>
        </div>
        <div class="feed-edit-container">

          <a href="post-edit.php?post_id=<?=$post_id;?>">
            <img class="feed-edit" src="assets/icons/edit.svg">
          </a>
        </div>
      <?php else: ?>
        <div class="feed-name-container">
          <a class="feed-avatar-link" href="profile-guest.php?profile_id=<?=$poster_id;?>"><?=$post['username'];?></a>
          <?=$ago?>
        </div>


      <?php endif; ?>
    </div>
    <div class="feed-img-container">
      <a href="post-view.php?post_id=<?=$post_id;?>">
        <img class="feed-img" src="<?='/assets/uploads/'.$post['content']?>">
      </a>
    </div>
    <div class="feed-interaction-container">
      <div>
        <?=$likes?> likes -
        <a href="post-view.php?post_id=<?=$post_id;?>"><?=$comments?> comments</a>
      </div>
      <?php if ($is_liked_by_user): ?>
        <a href="app/posts/unlike.php?post_id=<?=$post_id;?>&redirect=feed.php">
          <img class="like-button"src="assets/icons/heart_filled.svg">
        </a>
      <?php else: ?>
      <a href="app/posts/like.php?post_id=<?=$post_id;?>&redirect=feed.php">
        <img class="like-button"src="assets/icons/heart.svg">
      </a>
    <?php endif; ?>
    </div>
    <div class="feed-description">
      <p><?=$post['description'];?></p>
    </div>
  </div>
<?php endforeach; ?>
<?php
require __DIR__.'/views/navbar.php';
?>
</section>
<script type="text/javascript" src="assets/scripts/like.js">

    </script>
