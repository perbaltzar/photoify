<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';


// Checking if all POST are set and user is logged in
if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'],
          $_POST['password'], $_POST['username']) && is_logged_in())
  {
  // Putting POST into variable
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
  $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
  $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
  $biography = filter_var(trim($_POST['biography']), FILTER_SANITIZE_STRING);
  $updated_at = date("Y-m-d");
  $id = (int) $_SESSION['user']['id'];

  // Fetch password from database
  $user = get_user_by_id($id, $pdo);






  if (password_verify($_POST['password'], $user['password']))
  {


    // Check if email excists in the database
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    if (!$statement){
      die(var_dump($pdo->errorInfo()));
    }
    $statement->execute();
    $check_for_email = $statement->fetch(PDO::FETCH_ASSOC);
    // die(var_dump($check_for_email));
    if ($check_for_email && $check_for_email['email'] !== $user['email']) {
      $_SESSION['error'] = 'Email already excist in database';
      redirect('/profile-edit.php?edit=profile');
    }else{
      // Updating Database with new values
      $statement = $pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, username = :username, biography = :biography, updated_at = :updated_at WHERE id = :id");
      if (!$statement){
        die(var_dump($pdo->errorInfo()));
      }
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->bindParam(':username', $username , PDO::PARAM_STR);
      $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
      $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
      $statement->bindParam(':email', $email, PDO::PARAM_STR);
      $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
      $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
      $statement->execute();


      // Updating the Session Variable
      $_SESSION['user'] = get_user_by_id($id, $pdo);
    }
  }
  redirect('/../../profile-home.php');
}
