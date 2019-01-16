<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';

// If user is logged in, redirect to feed instead
if (is_logged_in()){
  redirect('/feed.php');
}
?>

<section class="login-container">
  <img class="login-logo" src="assets/images/logo.png">
  <div class="login-error-container">
    <?php if (isset($_SESSION['error'])): ?>
      <h6 class="login-error"><?=$_SESSION['error'];?></h6>
    <?php endif; ?>
  </div>
  <form class="login-form" action="app/users/login.php" method="post">
    <div class="login-group">
      <label class="login-label" for="email">Email</label>
      <input class="login-input" type="email" name="email" required>
    </div><!-- /form-group -->

    <div class="login-group">
      <label class="login-label" for="password">Password</label>
      <input class="login-input" type="password" name="password" required>
    </div><!-- /form-group -->

    <button class="login-button"type="submit" class="btn btn-primary">LOGIN</button>
  </form>
  <div class="login-register">
    Not a member yet? <a class="register-link" href="register.php">Register here</a>
  </div>
</section>
<?php require __DIR__.'/views/footer.php';
