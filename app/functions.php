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
function get_user_by_id(int $id, object $pdo): array
  {
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
/**
 * Returns if logged in user posted the post
 * @param  id of post
 * @param  id of user
 * @return bool         True or false
 */
function is_owner($post, $user): bool
{
  return $post === $user;
}

/**
 *
 * @return bool True if $_SESSION['user'] is set
 */
function is_logged_in () : bool
{
  return isset($_SESSION['user']);
}
