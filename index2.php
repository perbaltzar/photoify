<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';
?>


  <body>
    <h1>PHOTOIFY</h1>
    <?php
    if (is_logged_in()): ?>
            <h5>Welcome, <?= $_SESSION['user']['first_name'];?></h5>
    <?php endif;?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="post.php">Post</a>
    <a href="feed.php">Feed</a>
    <a href="profile-home.php">Your Profile</a>
    <a href="/app/users/logout.php">Logout</a>

    <?php
    require __DIR__.'/views/navbar.php';
    ?>
  </body>
</html>
