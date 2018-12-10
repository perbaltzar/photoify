<?php

declare(strict_types=1);


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Photoify</title>
  </head>
  <body>
    <center>
    <h1>Register User</h1>
    <form action="app/users/register.php" method="post">

              <label for="firstName">First Name</label>
              <input class="" type="text" name="firstName" placeholder="First Name" required>
              <br>
              <label for="lastName">Last Name</label>
              <input class="" type="text" name="lastName" placeholder="Last Name" required>
              <br>
              <label for="email">Email</label>
              <input class="" type="email" name="email" placeholder="Email" required>
              <br>
              <label for="email">Username</label>
              <input class="" type="text" name="username" placeholder="Username" required>
              <br>
              <label for="password">Password</label>
              <input class="" type="password" name="password" required>
              <br>
              <label for="password">Confirm Password</label>
              <input class="" type="password" name="confirmPassword" required>
              <br>
          <button type="submit" class="">Register</button>
      </form>
    </center>

  </body>
</html>
