<?php

declare(strict_types=1);

require __DIR__.'/app/autoload.php';

// Collecting data from Database
$statement = $pdo->prepare(
  "SELECT p.id as post_id, p.content, p.description, p.created_at, p.created_at,
  u.username, u.id as user_id, u.profile_picture
  FROM posts p INNER JOIN users u WHERE u.id = p.user_id"
 );
 if (!$statement){
   die(var_dump($pdo->errorInfo()));
 }
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
// die(var_dump($posts));
?>

<center>
<?php
//Looping through all the posts
foreach ($posts as $post) : ?>
  <?php if (is_owner($post['user_id'], $_SESSION['user']['id'])): ?>
    
    <img style="width: 30px; height: 30px;" src="<?='/assets/uploads/'.$post['profile_picture']?>"><?=$post['username'];?>:<br>

    <img style="width: 150px; height: 150px;" src="<?='/assets/uploads/'.$post['content']?>">
    <br>
    <p><?=$post['description'];?></p>

  <a href="app/posts/delete.php?post_id=<?=$post['id']?>">Delete this post</a>
  <a href="post-edit.php?post_id=<?=$post['id']?>">Edit this post</a>
  <br>
  <?php else: ?>
    <img style="width: 30px; height: 30px;" src="<?='/assets/uploads/'.$post['profile_picture']?>"><?=$post['username'];?>:<br>
    <img style="width: 150px; height: 150px;" src="<?='/assets/uploads/'.$post['content']?>">
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
  <?php endif; ?>
<?php endforeach; ?>
</center>
