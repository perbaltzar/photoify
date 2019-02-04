<?php

declare(strict_types=1);

// Always start by loading the default application setup.
require __DIR__.'/../app/autoload.php';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Photoify</title>
    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/root.css">
    <link rel="stylesheet" href="assets/styles/login.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/feed.css">
    <link rel="stylesheet" href="assets/styles/post.css">
    <link rel="stylesheet" href="assets/styles/profile-home.css">
    <link rel="stylesheet" href="assets/styles/edit.css">
    <link rel="stylesheet" href="assets/styles/comments.css">
    <link rel="stylesheet" href="assets/styles/search.css">
    <link rel="stylesheet" href="assets/styles/message.css">
    <link rel="stylesheet" href="assets/styles/display-message.css">
    <link rel="stylesheet" href="assets/styles/desktop.css">
  </head>
<body>
<?php require __DIR__.'/messages.php';
