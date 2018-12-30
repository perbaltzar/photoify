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
    <form method="post" enctype="multipart/form-data" action="app/posts/post.php">
      <label for="uploadFiles">Choose a JPG image to upload</label>
      <input type="file" accept="image/jpeg" name="content" required>
      <textarea name="description">Description</textarea>
      <button type="submit">Upload</button>
    </form>
    <?php
    require __DIR__.'/views/navbar.php';
    ?>
  </body>
</html>
