<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in() && isset($_GET['post_id'])) {
    $post_id = (int) filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $_SESSION['user']['id'];

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
    $ago = get_time(time()-strtotime($post['created_at']));
    $comments = get_comments_by_postid($post_id, $pdo);
    $likes = count_likes($post_id, $pdo);
    $is_liked_by_user = is_post_liked_by_user($id, $post_id, $pdo);
}

  ?>
  <section class="all-feed-container">
    <div class="feed-container">
      
        <div class="feed-avatar-container">
          <img class="feed-avatar" src="<?='/assets/uploads/'.$post['profile_picture']?>">
          <?php if (is_owner_of_post((int)$post['user_id'], $id)): ?>
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
              <a class="feed-avatar-link" href="profile-guest.php?profile_id=<?=$post['user_id'];?>"><?=$post['username'];?></a>
              <?=$ago?>
            </div>
          <?php endif; ?>
        </div>
      
      <div class="feed-img-container">

          <img class="feed-img" src="<?='/assets/uploads/'.$post['content']?>">
      
      </div>
      <div class="feed-interaction-container">
        <div>
          <p class="likes-post<?=$post_id?>"><?=$likes?> likes</p>
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
    </section>
    <?php
    require __DIR__.'/views/navbar.php';
    ?>
  <script src="assets/scripts/like.js">
  </script>
<?php require __DIR__.'/views/footer.php';
