<?php

declare(strict_types=1);

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
   * Counting likes
   *
   * @param integer $post_id id of post
   * @param object $pdo 
   * @return integer number of likes
   */
function count_likes(int $post_id, object $pdo): int 
{
  $statement = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  $likes = $statement->fetch(PDO::FETCH_ASSOC);

  return (int)$likes["COUNT(*)"];
}


/**
 * Counting comments
 *
 * @param integer $post_id id of post
 * @param object $pdo
 * @return integer  number of comments
 */
function count_comments(int $post_id, object $pdo): int 
{
  $statement = $pdo->prepare('SELECT COUNT(*) FROM comments WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $statement->execute();
  $comments = $statement->fetch(PDO::FETCH_ASSOC);
  return (int)$comments["COUNT(*)"];
}

/**
 * Check if post is liked by user
 *
 * @param integer $id id of user
 * @param integer $post_id id of post
 * @param object $pdo
 * @return boolean if it's like or not
 */
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

/**
 * Collecting all comments for a post
 *
 * @param integer $post_id
 * @param object $pdo
 * @return array
 */
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

/**
 * Counting number of followers for a users
 *
 * @param integer $id user id
 * @param object $pdo
 * @return integer
 */
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

/**
 * Counting how many a user follow
 *
 * @param integer $id user id
 * @param object $pdo
 * @return integer
 */
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

/**
 * Collect all post data from a users id
 *
 * @param integer $id post id
 * @param object $pdo
 * @return array
 */
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

/**
 * Collect all post data from a posts id
 *
 * @param integer $post_id
 * @param object $pdo
 * @return array
 */
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

/**
 * Collect all user data from email
 *
 * @param string $email
 * @param object $pdo
 * @return array
 */
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





