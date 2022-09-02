<?php
require "function.php";
require "database.php";
include 'template/header.php';
session_start();

$db = connection();

$product_id=$_POST['product_id'];
$quantity=$_POST['quantity'];


//Ajoute une ligne à la BD dans la table orders
addOrder($db, $product_id, $quantity);

//Besoin d'une fonction pour récupérer order_id

//$lastOrderId=getLastOrderId($db)[0]['id'];
//var_dump($lastOrderId);

//Ajoute une ligne à la BD dans la table order_product
//addOrderProduct($db, $lastOrderId, $product_id, $quantity);