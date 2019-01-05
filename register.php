<?php
// Always start by loading the default application setup.
require __DIR__.'/views/header.php';
?>
<section class="edit-section">
  <h1 class="edit-headline">REGISTER USER</h1>
  <form class="edit-form" action="app/users/register.php" method="post">
    <div class="edit-div">
      <div class="edit-label">
        <label for="firstName">First Name</label>
      </div>
      <input class="edit-input" type="text" name="firstName" placeholder="First Name" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="lastName">Last Name</label>
      </div>
      <input class="edit-input" type="text" name="lastName" placeholder="Last Name" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="email">Email</label>
      </div>
      <input class="edit-input" type="email" name="email" placeholder="Email" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="username">Username</label>
      </div>
      <input class="edit-input" type="text" name="username" placeholder="Username" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="password">Password</label>
      </div>
      <input class="edit-input" type="password" name="password" required>
    </div>
    <div class="edit-div">
      <div class="edit-label">
        <label for="password">Confirm Password</label>
      </div>
      <input class="edit-input" type="password" name="confirmPassword" required>
    </div>
    <button type="submit" class="edit-button">Register</button>
  </form>
</section>
<?php
if (isset($_SESSION['error'])){
  echo $_SESSION['error'];
}

?>
