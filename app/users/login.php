<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_POST['email'], $_POST['password'])){
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    //Collecting user from database
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    //Checking for excisting user
    if (!$user){
        $_SESSION['error'] = 'no user';
        redirect('/login.php');
    }

    //verifying password
    if (password_verify($_POST['password'], $user['password'])){
      $_SESSION['user'] = $user;
      redirect('/');
    }else{
      $_SESSION['error'] = 'Wrong Password';
      redirect('/login.php');
    }


}
