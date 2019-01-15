



<section class="edit-section">
  <!-- <h1 class="edit-headline">CHANGE PROFILE PICTURE</h1> -->
<div class="post-container">
    <form class="post-form" method="post" enctype="multipart/form-data" action="/../../app/users/profile-picture.php">
      <div class="post-file-label-container">
        Choose a file to upload
        <div class="post-upload-container">
          <label class="post-file-label" for="imgs">File</label>
          <input class="post-file" type="file" accept="image/*" name="content" id="imgs" required>
        </div>
      </div>
      <div class="post-preview-container post-preview-container-profile-picture">
        <img class="post-preview profile-picture-preview" src="assets/images/preview.jpg" alt="">
      </div>
      <button class="post-upload profile-picture-upload" type="submit">UPLOAD</button>
    </form>
</div>
</section>
<script type="text/javascript" src="assets/scripts/post.js">

</script>
