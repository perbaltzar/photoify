<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Check if user is logged in
if (!is_logged_in()) {
    $_SESSION['error'] = "Please log in and try again!";
    redirect('/');
}

if (isset($_POST['post_id'])) {
    $user_id = (int)$_SESSION['user']['id'];
    $created_at = date("Y-m-d");
    $post_id = (int) filter_var($_POST['post_id'], FILTER_VALIDATE_INT);

    // Check if like already excist in Database
    $statement = $pdo->prepare('SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $check_for_like = $statement->fetch(PDO::FETCH_ASSOC);

    // Put like in database if check_for_like is false
    if (!$check_for_like) {
        $statement = $pdo->prepare('INSERT INTO likes(post_id,
      user_id, created_at) VALUES(:post_id, :user_id, :created_at)');
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement->execute();
    }
    $likes = count_likes($post_id, $pdo);
    $likes = json_encode($likes);
    header('Content-Type: application/json');
    echo $likes;
}
