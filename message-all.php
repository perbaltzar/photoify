<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

if (is_logged_in()){
    $user_id = (int)$_SESSION['user']['id'];

    $statement = $pdo->prepare('SELECT conversation_id FROM conversation_members 
                                WHERE user_id = :user_id');
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $conversation_ids = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($conversation_ids as $conversation_id) {
        // print_r($conversation_id);
        $statement = $pdo->prepare(
            'SELECT u.username, u.id, u.profile_picture FROM conversation_members cm 
            INNER JOIN users u ON cm.user_id = u.id WHERE cm.conversation_id = :conversation_id 
            AND cm.user_id != :user_id'
        );
        if (!$statement){
            die(var_dump($pdo->errorInfo()));
        }
        $statement->bindParam(':conversation_id', $conversation_id['conversation_id'], PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $conversations[] = $statement->fetch(PDO::FETCH_ASSOC);
    }

    // die(var_dump($conversations));
}




?>

<section>
    <h1 class="edit-headline">MESSAGES</h1>
    <div>
        <?php
        foreach ($conversations as $conversation) : ?>   
            <a href="message.php?profile_id=<?=$conversation['id'];?>">
                <div class="comment-container">
                    <img class="comment-avatar" src="/assets/uploads/<?=$conversation['profile_picture'];?>">
                    <div class="">
                    <p class="comment-username"><?=$conversation['username'];?></p>
                </div>
            </div>
            </a>
        <?php endforeach;?>
    </div>
</section>

<?php
require __DIR__.'/views/navbar.php';
?>
</body>
</html>