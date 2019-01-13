<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

if (isset($_GET['profile_id']) && is_logged_in()){
    $user_id = (int)$_SESSION['user']['id'];
    $post_id = (int)$_GET['post_id'];
}



require __DIR__.'/views/header.php';

?>

<section>
    


</section>

<?php
require __DIR__.'/views/navbar.php';
?>
</body>
</html>