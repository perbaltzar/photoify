<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

 if (isset($_GET['post_id']) && is_logged_in()){
   $user_id = (int)$_SESSION['user']['id'];
   $post_id = (int)$_GET['post_id'];

   //Collecting data from database

   $statement = $pdo->prepare('SELECT * FROM posts WHERE user_id = :user_id AND id = :post_id');
   if (!$statement){
     die(var_dump($pdo->errorInfo()));
   }
   $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
   $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
   $statement->execute();
   $post = $statement->fetch(PDO::FETCH_ASSOC);
   // die(var_dump($post));
 }
?>

    <?php

    if ($post): ?>
    <section class="edit-post-container">
      <h1 class="edit-headline">EDIT POST</h1>
      <div class="edit-post-preview-container">
        <img class="edit-post-preview" src="assets/uploads/<?=$post['content'];?>">
      </div>
      <form class="post-form" method="post" enctype="multipart/form-data" action="app/posts/edit.php?post_id=<?=$post['id']?>">
        <div class="post-description-container">
          Edit your description
          <textarea class="post-description" placeholder="" name="description"><?=$post['description']?></textarea>
        </div>
        <button class="post-upload"type="submit">SAVE</button>
      </form>
    </section>
    <?php else: ?>
        Couldn't find your post, please try again
    <?php endif; ?>
    <?php
    require __DIR__.'/views/navbar.php';
    ?>

  </body>
</html>
