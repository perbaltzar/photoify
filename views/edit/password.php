<section class="edit-section">
    <h1 class="edit-headline">CHANGE PASSWORD</h1>
    <form class="edit-form" action="/../../app/users/password.php" method="post">
      <div class="edit-div">
        <div class="edit-label">
          <label for="firstName">Password</label>
        </div>
        <input class="edit-input" type="password" name="password" required>
      </div>
      <div class="edit-div">
        <div class="edit-label">
          <label for="lastName">New Password</label>
        </div>
        <input class="edit-input" type="password" name="new-password" required>
      </div>
      <div class="edit-div">
        <div class="edit-label">
          <label for="email">Repeat New Password</label>
        </div>
        <input class="edit-input" type="password" name="repeat-password" required>
      </div>
      <button type="submit" class="edit-button">Save</button>
    </form>
</section>
