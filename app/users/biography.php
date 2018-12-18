<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_POST['biography'], $_SESSION['user'])){
  //Saving Post data in variables
  $biography = filter_var(trim($_POST['biography']), FILTER_SANITIZE_STRING);
  $id = (int) $_SESSION['user']['id'];
  $updated_at = date("Y-m-d");
  //Update statement to database
  $statement = $pdo->prepare("UPDATE users SET updated_at = :updated_at, biography = :biography WHERE id = :id");
  if (!$statement){
    die(var_dump($pdo->errorInfo()));
  }
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->bindParam(':biography', $biography , PDO::PARAM_STR);
  $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
  $statement->execute();

  $_SESSION['user']['biography'] = $biography;
}else{
  $_SESSION['error'] = 'You\'re not logged in';
}
redirect('/home-profile.php');