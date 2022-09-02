<?php
require "function.php";
require "database.php";
include 'template/header.php';

session_start();
?>

<a href="index.php">Retourner à la liste des produits</a>

<?php

// Initialiser le panier dans la session la première fois
if( ! isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Connexion à la base de données
$db = connection();

// On ajoute le produit au panier
$product_id = intval($_POST['product_id']);
$product = getProductById($product_id, $db);


//Calcul de tous les élements nécessaires

$quantity=$_POST['quantity'];
$price=$product["price"];
$prixHT = (priceExcludingVAT($product["price"]));
$prixHTDiscount = priceExcludingVAT(discountedPrice($product["price"], $product["discount"]));
$TVA = ($price - $prixHT);
$TVAdiscount = discountedPrice($product["price"], $product["discount"]) - $prixHTDiscount;
$total = $price * $quantity;
$name=$product["name"];


// On retire du panier si 0
if ($quantity == 0) {
    unset($_SESSION["cart"][$product_id]);

    // Déjà dans le panier, mise à jour de la quantité
} elseif ( isset($_SESSION["cart"][$product_id])) {
    $_SESSION["cart"][$product_id]["quantity"] += $quantity;
    $_SESSION["cart"][$product_id]["total"] += $total;

    // Ajout au panier
} else {
    $_SESSION["cart"][$product_id] = [
        'quantity' => $quantity,
        'price' => $price,
        'name' => $name,
        'total' => $total,
    ];
}
?>
<h3><?= $product["name"]; ?></h3>
    <p>Prix TTC Unitaire :<?php formatPrice($price); ?></p>

    <?php if ($product["discount"] != null) { ?>
        <p>Prix Discount TTC Unitaire <?php echo $product["discount"] . "%" ?>
        <?php formatPrice(discountedPrice($product["price"], $product["discount"])); ?></p>
        <p>Quantité : <?php echo $quantity; ?></p>
        <p> Prix Total: <?php formatPrice(discountedPrice($product["price"], $product["discount"]) * $quantity); ?> </p>
        <p>Prix Total HT :<?php formatPrice($prixHTDiscount * $quantity); ?></p>
        <p>TVA: <?php formatPrice($TVAdiscount * $quantity); ?></p>
        <img src="<?php echo $product["image"]; ?> " >
<?php } ?>



    <form method="post" action="confirmation.php">
        <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
        <input type="hidden" name="quantity" value="<?= $quantity ?>">
        <hr>
        <input type="submit" value="Confirmation de la commande">
    </form>



<?php include 'template/footer.php'; ?>