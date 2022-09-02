<?php

//Formater le prix en EURO
function formatPrice($price)
{
    $price = $price / 100;
    echo number_format($price, 2, ',', '') . " €";
}

//Calcul prix HO
function priceExcludingVAT($priceVat): float
{
    return (100 * $priceVat) / (100 + 20);
}

function discountedPrice($price, $discount): float
{
    return $price * ((100 - $discount) / 100);
}
