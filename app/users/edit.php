<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';


// Checking if all POST are set
if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'],
          $_POST['password'], $_POST['username'])){


  // Putting POST into variable
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
  $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
  $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
  $description = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
  $updated_at = date("Y-m-d");


  // Fetch password from database
  $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id;');
  $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_ASSOC);

  if(password_verify($_POST['password'], $user['password'])){

    // Updating Database with new values
    $statement = $pdo->prepare('UPDATE users SET username = :username,
                                first_name = :first_name, last_name = :last_name,
                                email = :email, updated_at = :updated_at
                                WHERE id = :id;');

    $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
    $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':username ', $username , PDO::PARAM_STR);
    $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $statement->execute();


    // Updating the Session Variable
    $_SESSION['user'] = $user;
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id;');
    $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  }
  redirect('/../../home-profile.php');
}
