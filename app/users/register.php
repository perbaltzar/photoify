<?php

declare(strict_types=1);

require(__DIR__.'/../autoload.php');

// Checking if all variables are set
if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'],$_POST['password'], $_POST['username'], $_POST['confirmPassword'])) {
    // Checking if password and confirm password are the same
    if ($_POST['password'] === $_POST['confirmPassword']) {

    // Collection data from input fields
        $email = strtolower(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Your email doesn't quite look right, try another one!";
            redirect('/register.php');
        }
        $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
        $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
        $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $profile_picture = 'default-profile.jpg';
        $biography = 'No biography written yet';
        $created_at = date("Y-m-d");

        // Checking database to see if email already excist
        $user = get_user_by_email($email, $pdo);
        if (!empty($user)) {
            $_SESSION['error'] = 'Email already i use, try another one!';
            redirect('/register.php');
        }

        // Connect to database
        $statement = $pdo->prepare(
      'INSERT INTO users(email, first_name, last_name, username, password, created_at, profile_picture, biography)
      VALUES(:email, :first_name, :last_name, :username, :password, :created_at, :profile_picture, :biography)'
    );

        // Binding the variables and executing
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement->bindParam(':profile_picture', $profile_picture, PDO::PARAM_STR);
        $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
        $statement->execute();

        // Storing userinfo in SESSION-variable
        $_SESSION['user'] = get_user_by_email($email, $pdo);
        redirect('/feed.php');
    } else {
        //PASSWORDS DOESN'T MATCH
        $_SESSION['error'] = 'Passwords don\'t match';
    }
    redirect('/register.php');
}
