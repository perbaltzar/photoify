<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_POST['email'], $_POST['password'])){
    $email = strtolower(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL));
    unset($_SESSION['error']);

    //Collecting user from database
    $user = get_user_by_email($email, $pdo);

    //Checking for excisting user
    if (!$user){
        $_SESSION['error'] = 'No Such User';
        redirect('/');
    }

    //verifying password
    if (password_verify($_POST['password'], $user['password'])){
      $_SESSION['user'] = $user;
      redirect('/feed.php');
    }else{
      $_SESSION['error'] = 'Wrong Password';
      redirect('/');
    }


}
