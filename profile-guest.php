<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in()){
  if (isset($_GET['profile_id'])){
    // Collecting userdata from database
    $profile_id = (int)filter_var($_GET['profile_id'], FILTER_SANITIZE_NUMBER_INT);
    $profile = get_user_by_id($profile_id, $pdo);
    $user_id = (int)$_SESSION['user']['id'];
  }
  $posts = get_posts_by_userid($profile_id, $pdo);
  $followers = count_followers($profile_id, $pdo);
  $following = count_following($profile_id, $pdo);
 
}

?>

<section class="profile-container">
  <div class="profile-username-container">
    <div class="profile-username">
      <h5 class="profile-headline"><?= $profile['username']; ?></h5>
      <h6 class="profile-sub-headline"><?= $profile['first_name']." ".$profile['last_name'];?></h6>
    </div>
    <a href="followers.php?profile_id=<?= $profile_id ?>">
      <div class="guest-profile-followers">
        <h5 class="profile-headline"><?=$followers?></h5>
        <h6 class="profile-sub-headline">Followers</h6>
      </div>
    </a>
    <a class="following" href="following.php?profile_id=<?=$profile_id ?>">
      <div class="guest-profile-followers">
        <h5 class="profile-headline"><?=$following?></h5>
        <h6 class="profile-sub-headline">Following</h6>
      </div>
    </a>
  </div>
    <div class="profile-picture-container">
      <img class="profile-picture" src="assets/uploads/<?=$profile['profile_picture'];?>">
      <div class="guest-follow-buttons">

        <?php
        $statement = $pdo->prepare('SELECT * FROM followers
          WHERE user_id = :user_id AND follower_id = :follower_id');
        $statement->bindParam(':user_id', $profile_id, PDO::PARAM_INT);
        $statement->bindParam(':follower_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $check_if_follow = $statement->fetch(PDO::FETCH_ASSOC);
        if ($check_if_follow):?>
          <div class="guest-follow-button guest-start-follow ">
            <a href="app/users/unfollow.php?follow_id=<?=$profile_id?>">Unfollow</a>
          </div>
        <?php else: ?>
          <div class="guest-follow-button unfollow">
            <a href="app/users/follow.php?follow_id=<?=$profile_id?>">Follow</a>
          </div>
        <?php endif; ?>

        <div class="guest-follow-button">
          <a href="message.php?profile_id=<?=$profile_id?>">Message</a>
        </div>
      </div>
    </div>
    <div class="profile-biography">
      <?= $profile['biography']; ?>
    </div>
    <div class="profile-posts">
      <?php foreach ($posts as $post): ?>
        <div class="profile-post-container">
          <a href="post-view.php?post_id=<?=$post['id'];?>">
            <img class="profile-post" src="assets/uploads/<?=$post['content']?>">
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<script src="assets/scripts/thumbnail.js"></script>
<?php require __DIR__.'/views/navbar.php'; ?>
<?php require __DIR__.'/views/footer.php';
