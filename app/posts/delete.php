<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Check if user is logged in
if (!is_logged_in()) {
    $_SESSION['error'] = "Please log in and try again!";
    redirect('/');
}

if (isset($_GET['post_id'])) {
    $post_id = (int)filter_var($_GET['post_id'], FILTER_VALIDATE_INT);
    $user_id = (int)$_SESSION['user']['id'];
 
  
    $post = get_post_by_postid($post_id, $pdo);
  
    // Check if user own post
    if (!is_owner_of_post((int)$post['user_id'], $user_id)) {
        redirect('/');
    }

    // Removing file form folder
    $path = '/../../assets/uploads/'.$post['content'];
    unlink(__DIR__.$path);
  
    // Removing
    $statement = $pdo->prepare('DELETE FROM posts WHERE user_id = :user_id AND id = :post_id');
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->execute();
    $_SESSION['success'] = "Your post have been deleted";
}

redirect('/');
