<?php


function getTotalProduct() {
    // on initialise le total du nombre de produits à 0
    $totalProduits = 0;

    // !(a && b) == !a || !b
// !(a || b) == !a && !b    

// si le panier existe et n'est pas vide
    if(isset($_SESSION['products']) && !empty($_SESSION['products'])) {
        foreach($_SESSION['products'] as $index => $product) {
            $totalProduits += $product['qtt'] ;
        }
    }

    return $totalProduits;
}