<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = strtolower(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL));
    unset($_SESSION['error']);

    //Collecting user from database
    $user = get_user_by_email($email, $pdo);

    //Checking for excisting user
    if (!$user) {
        $_SESSION['error'] = 'We can find your user, please try again';
        redirect('/');
    }

    //verifying password
    if (password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user;
        $_SESSION['success'] = 'Welcome '.$user['username'];
        redirect('/feed.php');
    } else {
        $_SESSION['error'] = 'Wrong password, please try again!';
        redirect('/');
    }
}
