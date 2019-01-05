
    <h1 class="edit-headline">CHANGE PASSWORD</h1>
    <form class="edit-form" action="/../../app/users/edit.php" method="post">
      <label for="firstName">Password</label>
      <input class="edit-input" type="text" name="firstName" value="<?= $_SESSION['user']['first_name'];?>" required>

      <label for="lastName">New Password</label>
      <input class="edit-input" type="text" name="lastName" value="<?= $_SESSION['user']['last_name'];?>"placeholder="Last Name" required>

      <label for="email">Repeat New Password</label>
      <input class="edit-input" type="email" name="email" value="<?= $_SESSION['user']['email'];?>"placeholder="Email" required>

      <button type="submit" class="edit-button">Save</button>
    </form>
