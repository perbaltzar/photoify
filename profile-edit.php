<?php
// Always start by loading the default application setup.
require __DIR__.'/views/header.php';

if (isset($_GET['edit']) && is_logged_in()){
  $edit = $_GET['edit'];
  // die(var_dump($edit));
  
  //Getting the right kind of edit to put on page
  if ($edit === 'profile'){
    require __DIR__.'/views/edit/profile.php';
  }elseif($edit === 'picture'){
    require __DIR__.'/views/edit/picture.php';
  }elseif($edit === 'password'){
    require __DIR__.'/views/edit/password.php';
  }elseif($edit === 'delete'){
    require __DIR__.'/views/edit/delete.php';
  }elseif($edit === 'picture'){
    require __DIR__.'/views/edit/picture.php';
  }else{
    redirect('/profile-home.php');
  }
}

require __DIR__.'/views/navbar.php';
require __DIR__.'/footer.php';