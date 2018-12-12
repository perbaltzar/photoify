<?php

declare(strict_types=1);
require __DIR__.'/../../views/header.php';

if (isset($_POST['description'], $_FILES['content'])){
  $post = $_FILES['content'] ;
  // die(var_dump($post));


  if ($post['type'] === 'image/jpeg'){
    if ($post['size'] < 3000000){
      $postName = "/../../assets/posts-pictures/".date('ymd').'-'.$post['name'];
      move_uploaded_file($post['tmp_name'], __DIR__.$postName);
    }else{
      echo 'The uploaded file exceeded the file size limit.';
    }
  }else{
    echo 'The image file type is not allowed.';
  }
}
die;
redirect('/post.php');





?>
