<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

if (isset($_GET['profile_id'])){
    $profile_id = $_GET['profile_id'];

    $statement = $pdo->prepare('SELECT f.follower_id, u.username, u.id as user_id, u.profile_picture
        FROM followers f INNER JOIN users u 
        WHERE u.id = f.follower_id AND f.user_id = :profile_id'
    );
    $statement->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $statement->execute();
    $followers = $statement->fetchAll(PDO::FETCH_ASSOC);
    usort($followers, "sort_by_username");
}
 

?>

<section class="edit-post-container">
    <h1 class="edit-headline">FOLLOWERS</h1>
    <div>
        <div class="all-comments-container">
            <?php foreach ($followers as $follower): ?>
            <a href="profile-guest.php?profile_id=<?=$follower['follower_id'];?>">
            <div class="comment-container">
                <img class="comment-avatar" src="<?='/assets/uploads/'.$follower['profile_picture']?>">
                <div class="">
                    <p class="comment-username"><?=$follower['username'];?></p>
                </div>
            </div>
            </a>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php
require __DIR__.'/views/navbar.php';