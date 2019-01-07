<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in() && isset($_GET['post_id'])){
  $post_id = $_GET['post_id'];
  $id = $_SESSION['user']['id'];

  // Collecting data from database, tables users and posts
  $statement = $pdo->prepare(
    "SELECT p.id as post_id, p.content, p.description, p.created_at, p.updated_at,
    u.username, u.id as user_id, u.profile_picture
    FROM posts p INNER JOIN users u WHERE u.id = p.user_id AND p.id = :post_id"
  );
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();

  // Saving database in variable
  $post = $statement->fetch(PDO::FETCH_ASSOC);

  //Saving variable needed
  $ago = time()-strtotime($post['created_at']);
  $ago = date('d', $ago);

  // Collecting comments from database
  $statement = $pdo->prepare('SELECT c.id as comment_id, c.content,
    c.created_at, u.username, u.id as user_id, u.profile_picture
    FROM comments c INNER JOIN users u WHERE u.id = c.user_id AND c.post_id = :post_id'
  );
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
  // Counting the rows in likes table
  $statement = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  $likes = $statement->fetch(PDO::FETCH_ASSOC);
  $likes = $likes["COUNT(*)"];

  // Checking if it's liked by user
  $statement = $pdo->prepare('SELECT * FROM likes
    WHERE post_id = :post_id AND user_id = :user_id');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
    $statement->execute();
    $is_liked_by_user = $statement->fetch(PDO::FETCH_ASSOC);
  }

  ?>
  <section class="all-feed-container">
    <div class="feed-container">
      <div class="feed-avatar-container">
        <img class="feed-avatar" src="<?='/assets/uploads/'.$post['profile_picture']?>">
        <?php if (is_owner($post_id, $id)): ?>
          <div class="feed-name-container">
            <a class="feed-avatar-link" href="profile-home.php"><?=$post['username'];?></a>
            <?=$ago?> days ago
          </div>
          <div class="feed-edit-container">

            <a href="post-edit.php?post_id=<?=$post_id;?>">
              <img class="feed-edit" src="assets/icons/edit.svg">
            </a>
          </div>
        <?php else: ?>
          <div class="feed-name-container">
            <a class="feed-avatar-link" href="profile-guest.php?profile_id=<?=$poster_id;?>"><?=$post['username'];?></a>
            <?=$ago?> days ago
          </div>


        <?php endif; ?>
      </div>
      <div class="feed-img-container">

          <img class="feed-img" src="<?='/assets/uploads/'.$post['content']?>">
      
      </div>
      <div class="feed-interaction-container">
        <div>
          <?=$likes?> likes
        </div>
        <?php if ($is_liked_by_user): ?>
          <a href="app/posts/unlike.php?post_id=<?=$post_id;?>&redirect=feed.php">
            <img class="feed-like"src="assets/icons/heart_filled.svg">
          </a>
        <?php else: ?>
          <a href="app/posts/like.php?post_id=<?=$post_id;?>&redirect=feed.php">
            <img class="feed-like"src="assets/icons/heart.svg">
          </a>
        <?php endif; ?>
      </div>
      <div class="feed-description">
        <p><?=$post['description'];?></p>
      </div>

      <!-- PRINTING OUT COMMENTS -->
      <div class="all-comments-container">
        <?php foreach ($comments as $comment): ?>
          <div class="comment-container">
            <img class="comment-avatar" src="<?='/assets/uploads/'.$comment['profile_picture']?>">
            <div class="">
              <p class="comment-username"><?=$comment['username'];?></p>
              <p class="comment"><?=$comment['content'];?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="add-comment-container">
        <form class="add-comment-form" action="app/posts/comment.php?post_id=<?=$post_id?>&redirect=post-view.php" method="post">
          <textarea class="comment-text" name="comment" rows="" cols=""></textarea>
          <button class="comment-button" type="submit" name="button">Comment</button>
        </form>
      </div>
    <?php
    require __DIR__.'/views/navbar.php';
    ?>
  </section>














</body>
</html>
