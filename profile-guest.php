<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

if (is_logged_in()){
  if (isset($_GET['profile_id'])){
    // Collecting userdata from database
    $profile_id = (int)$_GET['profile_id'];
    $profile = get_user_by_id($profile_id, $pdo);
  }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <center>
    <h1>This Is Someone Else's Profile</h1>
    Name: <?= $profile['first_name']." ".$profile['last_name'];?> <br>
    Email: <?= $profile['email']; ?><br>
    Username: <?= $profile['username']; ?><br>
    Member since: <?= $profile['created_at']; ?><br>
    Profile Picture:
      <img style="width: 100px; height: 100px;" src="assets/uploads/<?=$profile['profile_picture'];?>"><a href="views/edit/picture.php">Upload new...</a>
    <br>


    Biography: <?= $profile['biography']; ?><br><a href="views/edit/biography.php">edit...</a><br>
    <a href="/views/edit/profile.php">Edit info...</a><br>
    <a href="/app/users/delete.php">Delete my user</a>
  </center>
  </body>
</html>
