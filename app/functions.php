<?php

declare(strict_types=1);


  /**
   * Redirect the user to given path.
   *
   * @param string $path
   *
   * @return void
   */
  function redirect(string $path)
  {
    header("Location: ${path}");
    exit;
  }


function getUserdata(string $email): array
  {
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
  }
