<?php

declare(strict_types=1);
require __DIR__.'/../header.php';




?>

<h1>EDIT PROFILE PICTURE</h1>
<form method="post" enctype="multipart/form-data" action="/../../app/users/profile-picture.php">
  <label for="uploadFiles">Choose an image to upload</label>
  <input type="file" accept="image/*" name="profile_picture" required>
  <button type="submit">Upload</button>
</form>
