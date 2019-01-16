<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in()){
  // $_SESSION['user'] = get_user_by_id ($_SESSION['user']['id'], $pdo);
  $biography = $_SESSION['user']['biography'];
  $username = $_SESSION['user']['username'];
  $name = $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'];
  $profile_picture = $_SESSION['user']['profile_picture'];
  $id = (int)$_SESSION['user']['id'];


  $posts = get_posts_by_userid($id, $pdo);
  $followers = count_followers($id, $pdo);
  $following = count_following($id, $pdo);

  

}

?>

<section class="profile-container">
  <div class="profile-username-container">
    <div class="profile-username">
      <h5 class="profile-headline"><?= $username ?></h5>
      <h6 class="profile-sub-headline"><?= $name;?></h6>
    </div>
    <a href="followers.php?profile_id=<?= $id ?>">
      <div class="profile-followers">
        <h5 class="profile-headline"><?=$followers?></h5>
        <h6 class="profile-sub-headline">Followers</h6>
      </div>
    </a>
    <a href="following.php?profile_id=<?= $id ?>">
      <div class="profile-followers">
        <h5 class="profile-headline"><?=$following?></h5>
        <h6 class="profile-sub-headline">Following</h6>
      </div>
    </a>
    <div class="profile-edit">
      <img class="profile-edit-icon" src="assets/icons/edit.svg" alt="">
    </div>
    <div class="profile-edit-menu visible">
      <ul>
        <li><a href="profile-edit.php?edit=picture">Change Profile Picture</a></li>
        <li><a href="profile-edit.php?edit=profile">Edit User</a></li>
        <li><a href="profile-edit.php?edit=password">Change Password</a></li>
        <li><a href="profile-edit.php?edit=delete">Delete User</a></li>
        <li><a href="app/users/logout.php">Log Out</a></li>
      </ul>
    </div>
  </div>
  <div class="profile-picture-container">
    <img class="profile-picture" src="assets/uploads/<?= $profile_picture ;?>">
  </div>
  <div class="profile-biography">
    <?= $biography; ?>
  </div>

  <div class="profile-posts">
    <?php foreach ($posts as $post): ?>
      <div class="profile-post-container">
        <a href="post-view.php?post_id=<?=$post['id'];?>">
            <img class="profile-post" src="assets/uploads/<?=$post['content']?>">
          </a>
      </div>
    <?php endforeach; ?>
  </di>





</section>
<script type="text/javascript" src="assets/scripts/profile-home.js"> </script>
<script src="assets/scripts/thumbnail.js"></script>
<?php
require __DIR__.'/views/navbar.php';
?>
</body>
</html>
