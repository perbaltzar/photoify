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


/**
 * Get a sentence with days, minutes or hours
 * @param  int    $time [time passed]
 * @return string       []
 */

function get_time(int $time): string{
  if ($time < (60*60))
  {
    return date('i', $time)." minutes ago";
  }
  elseif ($time > 60*60 && $time < 60*60*24)
  {
    return date('H', $time)." hours ago";
  }
  elseif ($time > 60*60*24 && $time < 60*60*24*7)
  {
    return date('d', $time)." days ago";
  }
  else
  {
    return date('d', $time)." days ago";
  }
}


function count_likes(int $post_id, object $pdo): int 
{
  $statement = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  $likes = $statement->fetch(PDO::FETCH_ASSOC);

  return (int)$likes["COUNT(*)"];
}

function count_comments(int $post_id, object $pdo): int 
{
  $statement = $pdo->prepare('SELECT COUNT(*) FROM comments WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  $comments = $statement->fetch(PDO::FETCH_ASSOC);
  return (int)$comments["COUNT(*)"];
}

function is_post_liked_by_user(int $id,int $post_id, object $pdo): bool
{
   $statement = $pdo->prepare('SELECT * FROM likes
    WHERE post_id = :post_id AND user_id = :user_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $is_liked_by_user = $statement->fetch(PDO::FETCH_ASSOC);
  // die(var_dump($is_liked_by_user));
  return $is_liked_by_user ? true : false;
}

function get_comments_by_postid(int $post_id, object $pdo): array
{
  $statement = $pdo->prepare('SELECT c.id as comment_id, c.content,
    c.created_at, u.username, u.id as user_id, u.profile_picture
    FROM comments c INNER JOIN users u WHERE u.id = c.user_id AND c.post_id = :post_id'
  );
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
  return $comments;
}

function count_followers(int $id, object $pdo): int 
{
  $statement = $pdo->prepare('SELECT COUNT(*) FROM followers WHERE user_id = :user_id');
  $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $followers = $statement->fetch(PDO::FETCH_ASSOC);
  $followers = (int) $followers["COUNT(*)"];
  if (!$followers){
    $followers = 0;
  }
  return $followers;
}

function count_following(int $id, object $pdo):int
{
  $statement = $pdo->prepare('SELECT COUNT(*) FROM followers WHERE follower_id = :user_id');
  $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $following = $statement->fetch(PDO::FETCH_ASSOC);
  $following = (int)$following["COUNT(*)"];

  if (!$following){
    $following = 0;
  }
  return $following;
}

function get_posts_by_userid (int $id, object $pdo): array
{
  $statement = $pdo->prepare(
    "SELECT * FROM posts WHERE user_id = :user_id"
  );
  $statement->bindParam('user_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
  // Reversing order so latest post is posted first
  return array_reverse($posts);
}

function get_post_by_postid (int $post_id, object $pdo): array
{
   $statement = $pdo->prepare('SELECT * FROM posts WHERE id = :post_id');
   if (!$statement){
     die(var_dump($pdo->errorInfo()));
   }
   $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
   $statement->execute();
   return $statement->fetch(PDO::FETCH_ASSOC);
}

function get_user_by_email(string $email, object $pdo): array
{
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email;');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user){
      return $user;
    }
    return $user = [];
}

function sort_by_username(array $a, array $b) 
{
  return strcmp($a['username'], $b['username']);
}

function search_name($users, $search): array 
{
  $ids = [];
  
  $search_lenght = strlen($search);
  $search = strtolower($search);
  foreach ($users as $user) 
  {
    $name_lenght = strlen($user['username']);
    for ($i=0; $i < $name_lenght ; $i++) 
    {
      $part_name = strtolower((substr($user['username'], $i, $search_lenght)));
      if ($part_name === $search)
      {
        $ids[] = [
          'id' => $user['id'], 
          'username' => $user['username'], 
          'profile_picture' => $user['profile_picture']
        ];
        break;
      }
    }

    if (!in_array($user['id'], $ids))
    {
      $name_lenght = strlen($user['first_name']);
      for ($i=0; $i < $name_lenght ; $i++) 
      {
        $part_name = strtolower((substr($user['first_name'], $i, $search_lenght)));
        if ($part_name === $search)
        {
          $ids[] = [
          'id' => $user['id'], 
          'username' => $user['username'], 
          'profile_picture' => $user['profile_picture']
        ];
          break;
        }
      }
    }
    if (!in_array($user['id'], $ids))
    {
      $name_lenght = strlen($user['last_name']);
      for ($i=0; $i < $name_lenght ; $i++) 
      {
        $part_name = strtolower((substr($user['last_name'], $i, $search_lenght)));
        if ($part_name === $search)
        {
          $ids[] = [
          'id' => $user['id'], 
          'username' => $user['username'], 
          'profile_picture' => $user['profile_picture']
        ];
          break;
        }
      }
    }




  }
  return $ids;
}