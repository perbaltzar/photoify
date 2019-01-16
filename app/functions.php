<?php

declare(strict_types=1);


/**
 * Redirect the user to given path.
 * @param string $path
 * @return void
 */
function redirect(string $path)
{
  header("Location: ${path}");
  exit;
}

/**
 * Returns if logged in user posted the post
 * @param  id of post
 * @param  id of user
 * @return bool         True or false
 */
function is_owner_of_post(int $post, int $user): bool
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
          $ids[] = $user['id'];
           
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
          $ids[] = $user['id'];
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
          $ids[] = $user['id'];
          break;
        }
      }
    }




  }
  
  
  return $ids;
}