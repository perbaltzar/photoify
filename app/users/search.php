<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';
    
if (!is_logged_in()) {
    $_SESSION['error'] = "Please log in and try again!";
    redirect('/');
}
if (isset($_POST['search'])) {
    $search = filter_var($_POST['search'], FILTER_SANITIZE_STRING);
    $statement = $pdo->prepare("SELECT * FROM users");
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    
    $ids = search_name($users, $search);
    
   
    foreach ($ids as $id) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $results[] = $statement->fetch(PDO::FETCH_ASSOC);
    }
    if (empty($results)) {
        $results = 'No users found :(';
    }

    $results = json_encode($results);
    header('Content-Type: application/json');
    echo $results;
}
