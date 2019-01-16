<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';

 if (isset($_GET['post_id']) && is_logged_in()){
   $user_id = (int)$_SESSION['user']['id'];
   $post_id = (int)filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);

   //Collecting data from database
   $post = get_post_by_postid($post_id, $pdo);
   if ($post)
   
   //Sends user back to feed if its not the poster
   if ((int)$post['user_id'] !== $user_id){
     redirect('/feed.php');
   }

 }
?>

<?php

if ($post): ?>
<section class="edit-post-container">
  <h1 class="edit-headline">EDIT POST</h1>
  <div class="edit-post-preview-container">
    <img class="edit-post-preview" src="assets/uploads/<?=$post['content'];?>">
  </div>
  <a href="app/posts/delete.php?post_id=<?=$post_id;?>"><img class="feed-edit delete-post" src="assets/icons/trash.svg"></a>
  <form class="post-form post-form-edit" method="post" enctype="multipart/form-data" action="app/posts/edit.php?post_id=<?=$post['id']?>">
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
<?php require __DIR__.'/views/navbar.php'; ?>
<?php require __DIR__.'/views/footer.php';
