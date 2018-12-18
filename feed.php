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

  <?php if ($post['user_id'] !== $_SESSION['user']['id']): ?>
    <img style="width: 150px; height: 150px;" src="<?=$post['content']?>">
    <br>
    <p><?=$post['description'];?></p>
    <br>
  <?php else: ?>
    <img style="width: 150px; height: 150px;" src="<?=$post['content']?>">
    <br>
    <p><?=$post['description'];?></p>
    <!-- NEED TO SEND POST ID TO DELETE, ASK VINCENT IF GET IS SAFE ENOUGH
        IF I'VE GOT USER ID AS WELL.!
     ?>-->
    <a href="app/posts/delete.php?post_id=<?=$post['id']?>">Delete this post</a>
    <br>
  <?php endif; ?>
<?php endforeach; ?>
</center>
