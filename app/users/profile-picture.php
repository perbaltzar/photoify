<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_SESSION['user'], $_FILES['profile_picture']))
{
  $profile_picture = $_FILES['profile_picture'] ;

  $id = (int) $_SESSION['user']['id'];

  $path = makeDirPath($id, 'profile');

  if (!file_exists(__DIR__.$path)){
    mkdir(__DIR__.$path);
  }

  $picture_name = time().'-'.$profile_picture['name'];
  move_uploaded_file($profile_picture['tmp_name'], __DIR__.$path.$picture_name);

  $picture_name = "/app/uploads/$id/profile/$picture_name";


  $statement = $pdo->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->bindParam(':profile_picture', $picture_name, PDO::PARAM_STR);
  $statement->execute();

  $_SESSION['user']['profile_picture'] = $picture_name;


  redirect('/');
}
