<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';
?>

    <div class="post-container">
        <form class="post-form" method="post" enctype="multipart/form-data" action="app/posts/post.php">
          <div class="post-upload-container">
            <label for="uploadFiles">Choose a picture to upload</label>
            <input class="post-file" type="file" accept="image/*" name="content" required>
          </div>
          <div class="post-preview-container">
            <img class="post-preview" src="assets/images/preview.jpg" alt="">
          </div>
          <div class="post-description-container">
            Write a caption
            <textarea class="post-description" placeholder="" name="description"></textarea>
          </div>
          <button class="post-upload"type="submit">UPLOAD</button>
        </form>
    </div>
    <script type="text/javascript" src="assets/scripts/post.js">

    </script>
    <?php
    require __DIR__.'/views/navbar.php';
    ?>
  </body>
</html>
