<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in()){
  if (isset($_GET['profile_id'])){
    // Collecting userdata from database
    $profile_id = (int)$_GET['profile_id'];
    $profile = get_user_by_id($profile_id, $pdo);
    $user_id = (int)$_SESSION['user']['id'];
  }
  $posts = get_posts_by_id($profile_id, $pdo);
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
    <div class="guest-profile-followers">
      <h5 class="profile-headline"><?=$followers?></h5>
      <h6 class="profile-sub-headline">Followers</h6>
    </div>
    <div class="guest-profile-followers">
      <h5 class="profile-headline"><?=$following?></h5>
      <h6 class="profile-sub-headline">Following</h6>
    </div>
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
          <a href="">Message</a>
        </div>
      </div>
    </div>
    <div class="profile-biography">
      <?= $profile['biography']; ?>
    </div>
    <div class="profile-posts">
      <?php foreach ($posts as $post): ?>
        <img class="profile-post" src="assets/uploads/<?=$post['content']?>">
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php
require __DIR__.'/views/navbar.php';
?>
</body>
</html>
