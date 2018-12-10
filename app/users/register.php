<?php

declare(strict_types=1);

require (__DIR__.'/../autoload.php');

// Checking if all variables are set
if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'],$_POST['password'], $_POST['username'], $_POST['confirmPassword'])){
  // Checking if password and confirm password are the same
  if ($_POST['password'] === $_POST['confirmPassword']){

    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
    $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $created_at = date("Y-m-d");


    // Connect to database
      $statement = $pdo->prepare(
        'INSERT INTO users(email, first_name, last_name, username, password, created_at)
        VALUES(:email, :first_name, :last_name, :username, :password, :created_at)');

      //BINDING THE VARIABLES
      $statement->bindParam(':email', $email, PDO::PARAM_STR);
      $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
      $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
      $statement->bindParam(':username', $username, PDO::PARAM_STR);
      $statement->bindParam(':password', $password, PDO::PARAM_STR);
      $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
      $statement->execute();
      // $userInfo = $statement->fetch(PDO::FETCH_ASSOC);

  }else{
  //PASSWORDS DOESN'T MATCH
  }
  redirect('/');
}
