<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

?>

<section>
    <div class="search-bar">
        <p class="search-p">Search for Usernames or Full Names</p>
        <form class="search-form" action="app/users/search.php" method="post">
            <input class="search-input" type="text" name="search" placeholder="Search" required>
        </form>
    </div>
    <div class="search-results">
        
    </div>
</section>
<script src="assets/scripts/search.js">
</script>

<?php
require __DIR__.'/views/navbar.php';
?>