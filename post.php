<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="post-container">
        <form class="post-form" method="post" enctype="multipart/form-data" action="app/posts/post.php">
          <div class="post-upload-container">
            <label for="uploadFiles">Choose a picture to upload</label>
            <input type="file" accept="image/jpeg" name="content" required>
          </div>
          <div class="post-preview">

          </div>
          <div class="post-description-container">
            Write a caption
            <textarea class="post-description" placeholder="Desription" name="description"></textarea>
          </div>
          <button class="post-upload"type="submit">UPLOAD</button>
        </form>
    </div>

    <?php
    require __DIR__.'/views/navbar.php';
    ?>
  </body>
</html>
