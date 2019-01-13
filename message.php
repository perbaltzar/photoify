<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

if (isset($_GET['profile_id']) && is_logged_in()){
    $user_id = (int)$_SESSION['user']['id'];
    $profile_id = (int)$_GET['profile_id'];

    $statement = $pdo->prepare(
        'SELECT m.to_id, m.from_id, m.content, m.created_at, u.username, u.profile_picture 
        FROM messages m INNER JOIN users u 
        ON m.to_id = u.id 
        WHERE m.to_id = :id AND m.from_id = :profile_id OR m.to_id = :profile_id AND m.from_id = :id'
        );
    if (!$statement){
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $statement->execute();
    $messages = $statement->fetchAll(PDO::FETCH_ASSOC);
   
    $to_user= get_user_by_id($profile_id, $pdo);

}




?>

<section class="message-section">
    <div class="comment-container">
        <img class="comment-avatar" src="assets/uploads/<?=$to_user['profile_picture'];?>">
        <h1 class="message-username-headline"><?=$to_user['username']?></h1>
    </div> 

    
    
    <div class="all-messages-container">
        <?php
        foreach ($messages as $message) : 
            //  die(var_dump($message));
            if ((int) $message['from_id'] === $user_id):?>
                <div class="own-message-container">
                    <p class="message">
                        <?=$message['content'];?>
                    </p>
                </div>
        <?php else: ?>
                <div class="message-container">
                    <p class="message">
                        <?=$message['content'];?>
                    </p>
                </div>
            <?php endif; ?>
        <?php endforeach;
        ?>
    </div>
        
        
    <div class="new-message-container">
        <form class="add-comment-form" action="app/users/message.php" method="post">
            <input type="hidden" name="profile_id" value="<?= $profile_id ?>" />
            <textarea class="comment-text" name="message" rows="" cols="" required></textarea>
          <button class="comment-button" type="submit" name="button">Send</button>
        </form>
        
    </div>
</section>

<?php
require __DIR__.'/views/navbar.php';
?>
</body>
</html>