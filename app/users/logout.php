<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

session_destroy();
$_SESSION['success'] = "You have successfully been logged out! Come back soon!";

redirect('/');
