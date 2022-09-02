<?php
//Local server InformationDB_CONNECTION=mysql
function connection(): PDO
{
    return new PDO("mysql:host=127.0.0.1; dbname=playground", "nicolasn", "p0lBb!-0YiWZpBsS");
}

// Lister l’ensemble des produits
function  SelectAllProducts(PDO $db): array{
    $query = "SELECT * FROM products";
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($productId, $db) {
    $query = "SELECT * FROM products WHERE id = $productId";
    $sql = $db->prepare($query);
    $sql->execute();
    return $sql->fetch(PDO::FETCH_ASSOC);
}

function addOrder(PDO $db, int $product_id, int $quantity){
    $query = "INSERT INTO `orders` (`customer_id`,`date`) 
                VALUES ('2', now())";
    $sql = $db->prepare($query);
    $sql->execute();
    $order_id = $db->lastInsertId();
    addOrderProduct($db, $order_id, $product_id, $quantity);

}
//

function getLastOrderId(PDO $db):array{
    $query = "SELECT `id` FROM `orders` ORDER BY `id` DESC LIMIT 1";
    $sql = $db->prepare($query);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);

}



function addOrderProduct(PDO $db,$order_id, $product_id, $quantity ):void{
$query = "INSERT INTO `order_product` (`order_id`, `product_id`, `quantity`) VALUES ('$order_id', '$product_id', '$quantity')";
$sql = $db->prepare($query);
$sql->execute();

}