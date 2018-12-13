<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';


// Checking if all POST are set and user is logged in
if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'],
          $_POST['password'], $_POST['username'], $_SESSION['user']))
  {
  // Putting POST into variable
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
  $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
  $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
  $description = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
  $updated_at = date("Y-m-d");
  $id = (int) $_SESSION['user']['id'];

  // Fetch password from database
  $user = getDataByID($id, $pdo);

  if (password_verify($_POST['password'], $user['password']))
  {
    // die(var_dump($user));
    // Updating Database with new values
    $statement = $pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, username = :username, updated_at = :updated_at WHERE id = :id");

    if (!$statement){
      die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':username', $username , PDO::PARAM_STR);
    $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $statement->execute();


    // Updating the Session Variable
    $_SESSION['user'] = getDataByID($id, $pdo);
  }
  redirect('/../../home-profile.php');
}
