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

  /**
  * Get data from Database by given ID
  * @param  int   $id []
  * @return array     [Array of userdata]
  */
function getDataByID(int $id, object $pdo): array
  {
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  /**
   * Create a string for path to directory
   * @param  int    $id   User ID
   * @param  string $name Name of folder
   * @return string full path to directory
   */
function makeDirPath(int $id, string $name): string {
  // return '/../uploads/'.$id.'/'.$name.'/';
  $format = "%s/uploads/$id/$name/";
  return sprintf($format, __DIR__);
}
