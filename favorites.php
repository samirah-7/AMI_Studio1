<?php
include "config.php";
$user_id = 1;

$stmt = $conn->prepare("
SELECT favorites.id AS fav_id,
products.*
FROM favorites
JOIN products
ON favorites.product_id = products.id
WHERE favorites.user_id = ?
");

$stmt->execute([$user_id]);

$favorites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Favorites</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Your Favorites ❤️</h1>

<div class="favorites-container">

<?php
if(count($favorites) > 0){

foreach($favorites as $fav){
?>

<div class="card">

  <img src="images/<?= $fav['image']; ?>">

  <h3><?= $fav['name']; ?></h3>

  <p><?= $fav['price']; ?> SAR</p>

  <a href="remove-favorite.php?id=<?= $fav['fav_id']; ?>">

    <button class="remove-btn">
      Remove 
    </button>

  </a>

</div>

<?php
}

}else{
  echo "<p>No favorites yet 💔</p>";
}
?>

</div>

</body>
</html>