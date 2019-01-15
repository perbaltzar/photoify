<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';


if (!is_logged_in())
{
  $_SESSION['error'] = 'You\'re Not Logged In';
  redirect('/');
}
//Check if follow id is set

if (isset($_GET['follow_id'])){
  $follow_id = (int)filter_var($_GET['follow_id'], FILTER_SANITIZE_NUMBER_INT);
  $user_id = (int)$_SESSION['user']['id'];

  // Check if row allready excist in database or return false if it's not
  // We do this so you can't unfollow the user you're not following
  $statement = $pdo->prepare('SELECT * FROM followers
    WHERE user_id = :user_id AND follower_id = :follower_id');
  $statement->bindParam(':user_id', $follow_id, PDO::PARAM_INT);
  $statement->bindParam(':follower_id', $user_id, PDO::PARAM_INT);
  $statement->execute();
  $check_if_follow = $statement->fetch(PDO::FETCH_ASSOC);

  if ($check_if_follow){
    $statement = $pdo->prepare('DELETE FROM followers
      WHERE user_id = :user_id AND follower_id = :follower_id');
    $statement->bindParam(':follower_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $follow_id, PDO::PARAM_INT);
    $statement->execute();
  }else{
    $_SESSION['error'] = 'You don\'t follow that user';
  }
}

redirect("/profile-guest.php?profile_id=$follow_id");
