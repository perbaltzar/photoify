



<section class="edit-section">
  <h1 class="edit-headline">CHANGE PROFILE PICTURE</h1>
<div class="post-container">
    <form class="post-form" method="post" enctype="multipart/form-data" action="/../../app/users/profile-picture.php">
      <div class="post-upload-container">
        <label for="uploadFiles">Choose a picture to upload</label>
        <input class="post-file" type="file" accept="image/*" name="profile_picture" required>
      </div>
      <div class="post-preview-container">
        <img class="post-preview profile-picture-preview" src="assets/images/preview.jpg" alt="">
      </div>
      <button class="post-upload"type="submit">UPLOAD</button>
    </form>
</div>
</section>
<script type="text/javascript" src="assets/scripts/post.js">

</script>
