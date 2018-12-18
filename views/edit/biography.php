<?php

declare(strict_types=1);
require __DIR__.'/../header.php';




?>

<h1>EDIT BIOGRAPHY</h1>
  <form action="/../../app/users/biography.php" method="post">
    <label for="biography">Biography</label>
    <textarea name="biography" rows="8" cols="80"></textarea>
    <br>
    <button type="submit" class="">Save</button>
  </form>
