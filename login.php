<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';
?>

<article class="login-container">
    <img class="login-logo" src="assets/images/logo.png">
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
</article>
