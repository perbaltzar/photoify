<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Photoify</title>
  </head>
  <body>
    <h1>PHOTOIFY</h1>
    <?php
    if (isset($_SESSION['user'])): ?>
            hej
            <h5>Welcome, <?= $_SESSION['user']['first_name'];?></h5>
    <?php endif;?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>


  </body>
</html>
