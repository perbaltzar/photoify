<?php

declare(strict_types=1);
require __DIR__.'/../header.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>EDIT PROFILE</h1>
    <form action="/../../app/users/edit.php" method="post">
      <label for="firstName">First Name</label>
      <input class="" type="text" name="firstName" value="<?= $_SESSION['user']['first_name'];?>" required>
      <br>
      <label for="lastName">Last Name</label>
      <input class="" type="text" name="lastName" value="<?= $_SESSION['user']['last_name'];?>"placeholder="Last Name" required>
      <br>
      <label for="email">Email</label>
      <input class="" type="email" name="email" value="<?= $_SESSION['user']['email'];?>"placeholder="Email" required>
      <br>
      <label for="email">Username</label>
      <input class="" type="text" name="username" value="<?= $_SESSION['user']['username'];?>" placeholder="Username" required>
      <br>
      <label for="password">Password</label>
      <input class="" type="password" name="password" required>
      <br>
      <button type="submit" class="">Save</button>
    </form>
  </body>
</html>
