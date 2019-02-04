<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Check if user is logged in
if (!is_logged_in()) {
    $_SESSION['error'] = 'You\'re Not Logged In';
    redirect('/');
}

if (isset($_POST['comment'], $_GET['post_id'])) {
    $redirect = filter_var($_GET['redirect'], FILTER_SANITIZE_STRING);
    $user_id = (int) $_SESSION['user']['id'];
    $content = trim(filter_var($_POST['comment'], FILTER_SANITIZE_STRING));
    $post_id = (int) filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("Y-m-d");

    $statement = $pdo->prepare(
    'INSERT INTO comments (post_id, user_id, content, created_at)
    VALUES (:post_id, :user_id, :content, :created_at)'
  );
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    $statement->execute();
}
redirect("/$redirect?post_id=$post_id");
