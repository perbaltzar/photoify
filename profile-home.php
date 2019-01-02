<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in()){
  $biography = $_SESSION['user']['biography'];
  $username = $_SESSION['user']['username'];
  $name = $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'];
  $profile_picture = $_SESSION['user']['profile_picture'];
  $id = (int)$_SESSION['user']['id'];

  //Collecting posts from database
  $statement = $pdo->prepare(
    "SELECT * FROM posts WHERE user_id = :user_id"
  );
  $statement->bindParam('user_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
  // die(var_dump($posts));

  // Counting number of followers in database
  $statement = $pdo->prepare('SELECT COUNT(*) FROM followers WHERE user_id = :user_id');
  $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $followers = $statement->fetch(PDO::FETCH_ASSOC);
  $followers = $followers["COUNT(*)"];
  if (!$followers){
    $followers = 0;
  }
  // Counting number of followings in database
  $statement = $pdo->prepare('SELECT COUNT(*) FROM followers WHERE follower_id = :user_id');
  $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $following = $statement->fetch(PDO::FETCH_ASSOC);
  $following = $following["COUNT(*)"];

  if (!$following){
    $following = 0;
  }

}

?>

<section class="profile-container">
  <div class="profile-username-container">
    <div>
      <h5><?= $_SESSION['user']['username']; ?></h5>
      <h6><?= $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'];?></h6>
    </div>
    <div class="profile-followers">
      <h5><?=$followers?></h5>
      <h6>Followers</h6>
    </div>
    <div class="profile-followers">
      <h5><?=$following?></h5>
      <h6>Following</h6>
    </div>

  </div>
  <div class="profile-picture-container">
    <img class="profile-picture" src="assets/uploads/<?=$_SESSION['user']['profile_picture'];?>">
  </div>
  <div class="profile-biography">
    <?= $_SESSION['user']['biography']; ?>
  </div>
  <div class="profile-posts">
    <?php foreach ($posts as $post): ?>
      <img class="profile-post" src="assets/uploads/<?=$post['content']?>">

    <?php endforeach; ?>
  </div>

  Email: <?= $_SESSION['user']['email']; ?><br>

  Member since: <?= $_SESSION['user']['created_at']; ?><br>



</section>
<?php
require __DIR__.'/views/navbar.php';
?>
</body>
</html>
