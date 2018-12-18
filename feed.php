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

<?php
//Looping through all the posts
foreach ($posts as $post) : ?>
    <img src="<?=$post['content']?>">
    <br>
    <p><?=$post['description'];?></p>
    <br>
<?php endforeach; ?>
