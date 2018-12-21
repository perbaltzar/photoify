<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (is_logged_in() && isset($_FILES['profile_picture']))
{
  $profile_picture = $_FILES['profile_picture'] ;
  $id = (int) $_SESSION['user']['id'];

  if ($profile_picture['type'] == 'image/jpeg' || $profile_picture['type'] == 'image/png')
  {

    //Create file name and save in directory
    $path = '/../../assets/uploads/';
    $picture_name = time().'-'.$id.'-'.$profile_picture['name'];
    move_uploaded_file($profile_picture['tmp_name'], __DIR__.$path.$picture_name);

    //Preparing and Excuting database-query
    $statement = $pdo->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':profile_picture', $picture_name, PDO::PARAM_STR);
    $statement->execute();

    //Storing path and name in session variable
    $_SESSION['user']['profile_picture'] = $picture_name;
  }

  //Sending back to profile page
  redirect('/profile-home.php');
}
