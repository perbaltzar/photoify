<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// Checking if user is logged in
if (!is_logged_in())
{
  $_SESSION['error'] = 'You\'re Not Logged In';
  redirect('/');
}
if (isset($_POST['password'], $_POST['new-password'], $_POST['repeat-password']))
{
    $password = $_POST['password'];
    $new_password = $_POST['new-password'];
    $repeat_password = $_POST['repeat-password'];
    $id = (int) $_SESSION['user']['id'];

    if ($new_password !== $repeat_password)
    {
        redirect('/profile-edit.php?edit=password');
    }

    // Collect data from database
    $user = get_user_by_id($id, $pdo);
    if (password_verify($password, $user['password']))
    {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $statement = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        if (!$statement){
            die(var_dump($pdo->errorInfo()));
        }
        $statement->bindParam(':password', $new_password, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        redirect('/profile-home.php');
    }
    redirect('/profile-edit.php?edit=password');
}