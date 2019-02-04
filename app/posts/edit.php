<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Check if user is logged in
if (!is_logged_in()) {
    $_SESSION['error'] = "Please log in and try again!";
    redirect('/');
}

if (isset($_GET['post_id'], $_POST['description'])) {
    $post_id = (int) filter_var($_GET['post_id'], FILTER_VALIDATE_INT);
    $user_id = (int)$_SESSION['user']['id'];
    $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
    $updated_at = date("Y-m-d");
    $post = get_post_by_postid($post_id, $pdo);

    if (is_owner_of_post((int) $post['user_id'], $user_id)) {
        $statement = $pdo->prepare('UPDATE posts SET description = :description, updated_at = :updated_at 
                                WHERE user_id = :user_id AND id = :post_id');
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $statement->execute();
        $_SESSION['success'] = "Changes has been saved!";
    } else {
        $_SESSION['error'] = "Oops, something went wrong here. Please try again later!";
    }
}
redirect('/feed.php');
