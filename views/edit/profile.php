
<section class="edit-section">
  <h1 class="edit-headline">EDIT PROFILE</h1>
  <form class="edit-form" action="/../../app/users/edit.php" method="post">
    <div class="edit-div">
      <div class="edit-label">
        <label for="firstName">First Name</label>
      </div>
      <input class="edit-input" type="text" name="first_name" value="<?= $_SESSION['user']['first_name'];?>" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="lastName">Last Name</label>
      </div>
      <input class="edit-input" type="text" name="last_name" value="<?= $_SESSION['user']['last_name'];?>"placeholder="Last Name" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="email">Email</label>
      </div>
      <input class="edit-input" type="email" name="email" value="<?= $_SESSION['user']['email'];?>"placeholder="Email" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="email">Username</label>
      </div>
      <input class="edit-input" type="text" name="username" value="<?= $_SESSION['user']['username'];?>" placeholder="Username" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="email">Biography</label>
      </div>
      <textarea class="edit-textarea" name="biography" rows="4" cols="60" maxlength="200"><?= $_SESSION['user']['biography'];?></textarea>

    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="password">Password</label>
      </div>
      <input class="edit-input" type="password" name="password" required>
    </div>
    <button class="edit-button" type="submit" class="">Save</button>
  </form>
</section>
