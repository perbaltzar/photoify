<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>This Is Your Profile</h1>
    Name: <?= $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'];?> <br>
    Email: <?= $_SESSION['user']['email']; ?><br>
    Username: <?= $_SESSION['user']['username']; ?><br>
    Member since: <?= $_SESSION['user']['created_at']; ?><br>
    Profile Picture:
      <img src="<?=$_SESSION['user']['profile_picture'];?>">
    <br>


    Biography: <?= $_SESSION['user']['description']; ?><br>
    <a href="/views/edit/edit-profile.php">Edit...</a><br>
    <a href="/app/users/delete.php">Delete my user</a>
  </body>
</html>
