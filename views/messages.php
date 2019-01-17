<?php

declare(strict_types=1);

if (isset($_SESSION['error'])):?>   
    <div class="display-message error">
        <h1><?=$_SESSION['error']?></h1>
    </div>
<?php elseif (isset($_SESSION['success'])): ?>
    <div class="display-message success">
        <h1><?=$_SESSION['success']?></h1>
    </div>
<?php endif;?>