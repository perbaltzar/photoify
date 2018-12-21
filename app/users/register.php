<?php

declare(strict_types=1);

require (__DIR__.'/../autoload.php');

// Checking if all variables are set
if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'],$_POST['password'], $_POST['username'], $_POST['confirmPassword'])){
  // Checking if password and confirm password are the same
  if ($_POST['password'] === $_POST['confirmPassword']){

    // Collection data from input fields
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
    $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $profile_picture = 'default-profile.jpg';
    $created_at = date("Y-m-d");

    // Checking database to see if email already excist
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email;');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user){
      $_SESSION['error'] = 'Email already excist';
      redirect('/register.php');
    }

    // Connect to database
    $statement = $pdo->prepare(
      'INSERT INTO users(email, first_name, last_name, username, password, created_at, profile_picture)
      VALUES(:email, :first_name, :last_name, :username, :password, :created_at, :profile_picture)'
    );

    // Binding the variables and executing
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    $statement->bindParam(':profile_picture', $profile_picture, PDO::PARAM_STR);
    $statement->execute();

    // Collecting the data from database to keep new user logged in.
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email;');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Storing userinfo in SESSION-variable
    $_SESSION['user'] = $user;
    redirect('/');
  }else{
    //PASSWORDS DOESN'T MATCH
    // die(var_dump('hej'));
    $_SESSION['error'] = 'Passwords don\'t match';
  }
  redirect('/register.php');
}
