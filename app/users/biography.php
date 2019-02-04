<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Check if user is logged in
if (!is_logged_in()) {
    $_SESSION['error'] = 'You\'re Not Logged In';
    redirect('/');
}

if (isset($_POST['biography'])) {
    //Saving Post data in variables
    $biography = filter_var(trim($_POST['biography']), FILTER_SANITIZE_STRING);
    $id = (int) $_SESSION['user']['id'];
    $updated_at = date("Y-m-d");

    //Update statement to database
    $statement = $pdo->prepare("UPDATE users SET updated_at = :updated_at, biography = :biography WHERE id = :id");
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    //Binding parameters to variables and executing databse query
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
    $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $statement->execute();

    //Storing biography in session variable
    $_SESSION['user']['biography'] = $biography;
    $_SESSION['success'] = "Your profile picture has been updated!";
} else {
    //Returning error-message
    $_SESSION['error'] = "Please log in and try again!";
}

//Redirecting back to profile
redirect('/profile-home.php');
