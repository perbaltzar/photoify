<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';
    
    $search = $_POST['search'];
    $statement = $pdo->prepare("SELECT * FROM users");
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    
    $ids = search_name($users, $search);   
    
   
    foreach ($ids as $id)
    {
        $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $statement->bindParam(':id', $id,PDO::PARAM_INT);
        $statement->execute();
        $results[] = $statement->fetch(PDO::FETCH_ASSOC);
    }
    if (empty($results))
    {
        $results = 'No users found';
    }

    $results = json_encode($results);
    header ('Content-Type: application/json');
    echo $results;

/*


if (isset($_POST['search'])){

    // $search = $_POST['search'];
    $statement = $pdo->prepare("SELECT * FROM users");
    $statement->execute();
    $users = $statement->fetch(PDO::FETCH_ASSOC);

    //CHANGE CASE
    
    //GO TROUGH USERNAME, NAME, FIRSTNAME
    
    $ids = search_name($users, $search);    
    
    die(var_dump($ids));

    $ids = json_encode($ids);
    header ('Content-Type: application/json');
    echo $ids;
}
*/