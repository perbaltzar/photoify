<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';
// Checking if all POST are set
if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'],
          $_POST['password'], $_POST['username'])){

  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
  $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
  $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
  $description = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);

  // Fetch password from database
  $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id;');
  $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_ASSOC);
  die(var_dump($user));


  if(password_verify($_POST['password'], $user['password'])){


  }


  redirect('/../../home-profile.php');
}
