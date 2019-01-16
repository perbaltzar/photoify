<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

if (isset($_GET['profile_id']) && is_logged_in()){
    $conversation_exist = false;
    $user_id = (int)$_SESSION['user']['id'];
    $profile_id = (int) filter_var($_GET['profile_id'], FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("Y-m-d");
    
    
    // Check if conversation exist
    $statement = $pdo->prepare('SELECT conversation_id FROM conversation_members 
                                WHERE user_id = :user_id');
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $conversation_ids = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($conversation_ids as $conversation_id) 
    {
        $statement = $pdo->prepare('SELECT user_id FROM conversation_members 
                                    WHERE conversation_id = :conversation_id AND user_id != :user_id');
        $statement->bindParam(':conversation_id', $conversation_id['conversation_id'], PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $profile_id_check = $statement->fetch(PDO::FETCH_ASSOC);
        
        // print_r($profile_id_check);
        
        // print_r($profile_id);
        if ((int) $profile_id_check['user_id'] === $profile_id)
        {
            $conversation_id = $conversation_id['conversation_id'];
            $conversation_exist = true;
            break;
        }
    }
    

    // die(var_dump($conversation_exist, $profile_id_check));
    if (!$conversation_exist)
    {
        // CREATING A CONVERSTION IF NOT EXISTS
        $statement = $pdo->prepare('INSERT INTO conversations(created_at) VALUES (:created_at)');
        $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        
        $statement->execute();
        $conversation_id = (int) $pdo->lastInsertId();
        
        // Adding active user in members table
        $statement = $pdo->prepare('INSERT INTO conversation_members (conversation_id, user_id) 
                                VALUES (:conversation_id, :user_id)');
        $statement->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        
        // Adding profile user in members table
        $statement = $pdo->prepare('INSERT INTO conversation_members (conversation_id, user_id) 
                                    VALUES (:conversation_id, :profile_id)');
        $statement->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
        $statement->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
        $statement->execute();
    }
    

    // GET MESSAGES FROM CONVERSATION
    $statement = $pdo->prepare('SELECT m.sender_id, m.content, u.username, u.profile_picture FROM messages m 
        INNER JOIN users u ON m.sender_id = u.id WHERE conversation_id = :conversation_id');
    $statement->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
    $statement->execute();
    $messages = $statement->fetchAll(PDO::FETCH_ASSOC);


   
    $to_user= get_user_by_id($profile_id, $pdo);
    // die(var_dump($messages, $conversation_id));
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
            if ((int) $message['sender_id'] === $user_id):?>
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
            <input type="hidden" name="conversation_id" value="<?= $conversation_id ?>" />
            <textarea class="comment-text" name="message" rows="" cols="" required></textarea>
          <button class="comment-button" type="submit" name="button">Send</button>
        </form>
        
    </div>
</section>
<?php
require __DIR__.'/views/navbar.php';
?>
