<?php

declare(strict_types=1);

require __DIR__.'/app/autoload.php';

// Collecting data from Database
$statement = $pdo->prepare(
  'SELECT * FROM posts;'
 );
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
// die(var_dump($posts));
?>

<center>
<?php
//Looping through all the posts
foreach ($posts as $post) : ?>

    <!-- Skriv en funktion istället! -->
  <?php if ($post['user_id'] !== $_SESSION['user']['id']): ?>
    <img style="width: 150px; height: 150px;" src="<?=$post['content']?>">
    <br>
    <p><?=$post['description'];?></p>
    <br>
    <!-- Likebutton -->
    <?php


    ?>

    <a href="app/posts/like.php?post_id=<?=$post['id'];?>">Like</a>
    <a href="app/posts/like.php?post_id=<?=$post['id'];?>">Unlike</a>
    <br><br><br>
    <br>
  <?php else: ?>
    <img style="width: 150px; height: 150px;" src="<?=$post['content']?>">
    <br>
    <p><?=$post['description'];?></p>
    <!-- NEED TO SEND POST ID TO DELETE? ASK VINCENT IF GET IS SAFE ENOUGH
        IF I'VE GOT USER ID AS WELL!
     -->
    <a href="app/posts/delete.php?post_id=<?=$post['id']?>">Delete this post</a>
    <a href="post-edit.php?post_id=<?=$post['id']?>">Edit this post</a>
    <br>
  <?php endif; ?>
<?php endforeach; ?>
</center>
