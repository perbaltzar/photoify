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
<section class="all-feed-container all-sections">

  <?php
  // Looping through all the posts
  foreach ($posts as $post) :

  // Storing variables
  $post_id = (int)$post['post_id'];
  $poster_id = (int)$post['user_id'];

  $likes = count_likes($post_id, $pdo);
  $comments = count_comments($post_id, $pdo);
  $ago = get_time(time()-strtotime($post['created_at']));
  // die(var_dump($id, $post_id));
  $is_liked_by_user = is_post_liked_by_user($id, $post_id, $pdo);
 
  ?>

  <div class="feed-container">
    <div class="feed-avatar-container">
      <img class="feed-avatar" src="<?='/assets/uploads/'.$post['profile_picture']?>">
      <?php if (is_owner_of_post($poster_id, $id)): ?>
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
      <div class="feed-comments-and-likes-container">
        <p class="likes-post<?=$post_id?> feed-comments-and-likes"><?=$likes?> likes </p> 
        <a href="post-view.php?post_id=<?=$post_id;?>"><p class="feed-comments-and-likes"> - <?=$comments?> comments</p></a>
      </div>
        <form method="post" class="like-button-form" >
          <input type="hidden" name="post_id" value="<?= $post_id ?>" />
          <input type="hidden" name="action" value="<?= $is_liked_by_user ? 'unlike' : 'like' ?>" />
          <button data-id="<?=$post_id?>" class="like-button" type="submit">
            <img class="like-button-<?=$post_id?> like-button-img <?= $is_liked_by_user ? '' : 'hidden' ?>" src="assets/icons/heart_filled.svg">
            <img class="like-button-<?=$post_id?> like-button-img <?= $is_liked_by_user ? 'hidden' : '' ?>" src="assets/icons/heart.svg">
          </button>
        </form>
    </div>
    <div class="feed-description">
      <p><?=$post['description'];?></p>
    </div>
  </div>
<?php endforeach; ?>
</section>
<script type="text/javascript" src="assets/scripts/like.js">
</script>
<?php require __DIR__.'/views/navbar.php'; ?>
<?php require __DIR__.'/views/footer.php';
