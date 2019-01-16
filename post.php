<?php

declare(strict_types=1);
require __DIR__.'/views/header.php';
?>
<section class="edit-section">
  <!-- <h1 class="edit-headline">POST A PICTURE</h1> -->
  <div class="post-container">
      <form class="post-form" method="post" enctype="multipart/form-data" action="app/posts/post.php">
        <div class="post-file-label-container">
          Choose a file to upload
          <div class="post-upload-container">
            <label class="post-file-label" for="imgs">File</label>
            <input class="post-file" type="file" accept="image/*" name="content" id="imgs" required>
          </div>
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
</section>
<script type="text/javascript" src="assets/scripts/post.js">

</script>
<?php require __DIR__.'/views/navbar.php'; ?>
<?php require __DIR__.'/views/footer.php';
