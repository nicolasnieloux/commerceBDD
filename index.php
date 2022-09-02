<?php
require "function.php";
require "database.php";

$db = connection();
$products = selectAllProducts($db);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ecommerce pour manger</title>
</head>
    <body>

<?php include 'template\header.php';?>

<?php foreach ($products as $product) { ?>

<div>

    <h3><?= $product["name"] ?></h3>
    <p>Prix TTC : <?php formatPrice($product["price"]); ?></p>
    <p>Prix HT : <?php formatPrice(priceExcludingVAT($product["price"])); ?></p>
    <?php if ($product["discount"]!= null) { ?>
        <p>Prix Discount <?= $product["discount"] . "%" ?>
            : <?php formatPrice(discountedPrice($product["price"], $product["discount"])); ?></p>
    <?php } else { ?>
        <p> Attend les soldes </p>
    <?php } ?>
    <img src="<?= $product["image"] ?>">


<form method="post" action="cart.php">
        <label for="quantity"> Quantité :</label>
        <input type="number" name="quantity" min="0" max="10">
        <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
        <input type="submit" value="Add to cart">
    <hr>
    </form>

<?php } ?>

    <hr>


</div>



<?php include "template/footer.php"; ?>
    </body>
</html>


