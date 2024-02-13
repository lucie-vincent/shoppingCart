<?php
//  cette page va permettre d'afficher la liste des produits présents
//  en session de manière organisée + le total de leur ensemble
//  il faudra pour ce faire parcourir le tableau de session, donc on
//  appelle la fct session_start() en début de fichier pour récupérer
//  la session utilisateur

session_start();

ob_start();
// var_dump($_SESSION['products']);
// die();

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

  // on ajoute un message qu'on affiche à l'utilisateur pour le prévenir
  // $totalProduits == 0 => si le panier 'existe pas en sesson ou qu'il est vide
  if($totalProduits == 0) {
      echo"<p>Aucun produit en session...</p>";
  } else {
    // on affiche le contenu de $_SESSION['products'] dans un tableau HTML <table>
    echo "<form >",
    "<table class=table table-hover>",
                "<thead>",
                    "<tr class=table-active>",
                        "<th>#</th>",
                        "<th>Nom</th>",
                        "<th>Prix</th>",
                        "<th>Quantité</th>",
                        "<th>Total</th>",
                    "</tr>",
                "</thead>",
                "<tbody>";
                //  on initialise la variable $totalGeneral à zéro
                $totalGeneral = 0;
        // on utilise la boucle itérative foreach() qui va exécuter
        // produit par produit les mêmes instructions et permettre 
        // l'affichage de chacun d'eux
        // pour chaque donnée dans $_SESSION['products], on a dans
        // la boucle 2 variables
        // 1. $index a pour valeur l'index du tableau parcouru.
        // On pourra numéroter chaque produit avec ce numéro dans le tableau HTML
        // 2. $product content le produit sous forme de tableau,
        // tel que crée et stocké en session par le fichier traitement.php
        foreach($_SESSION['products'] as $index => $product) {
            echo "<tr>",
                    "<td>" . $index . "</td>",

                    "<td> <img src='upload/" .$product['imgName']. " '/> </td>",

                    "<td>" . $product['name'] . "</td>",

                    // number_format() permet de modifier l'affichage
                    // d'une valeur numérique en précisant plsrs paramètres
                    // number_format(variable à modifier, nombre de
                    // décimales souhaité, caractère séparateur décimal, 
                    // caractère séparateur de milliers);
                    // &nbsp; = espace insécable
                    "<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€</td>",
                    //on utilise la balise <a> avec "nomPage.php, ?action=nom-action, & pour les paramètres en
                    // clé=valeur"
                    "<td><a href='traitement.php?action=modifier-qtt&id=$index&augmenter=false'> - </a>" 
                    . $product['qtt'] .
                    "<a href='traitement.php?action=modifier-qtt&id=$index&augmenter=true'> + </a>",

                    "<td>" . number_format($product['total'], 2, ",", "&nbsp;") .
                    "&nbsp;€&nbsp;<a href='traitement.php?action=supprimer-produit&id=$index'>
                    <i class='fa-solid fa-trash-can'></i> </a></td>",
                  "</tr>";
                  //  grace à l'opérateur combiné +=, on ajoute le
                  // total du produit parcouru à la valeur de $totalGeneral, 
                  // qui augmente d'autant pour chaque produit
                  //  autre syntaxe : $totalGeneral = $totalGeneral + $produit["total"];
                  $totalGeneral += $product['total'];
            }
        echo "<tr>",
                // la ligne qui suit contient 2 cellules : 1 cellule
                // fusionnée de 4 cellules (colspan=4) pour l'intitulé
                // et une cellule affichant le contenu formaté 
                // de $totalGeneral avec number_format
                "<td colspan=4>Total général : </td>",
                "<td><strong>" . number_format($totalGeneral, 2, ",", "&nbsp;") 
                . "&nbsp;€</strong></td>",
              "</tr>",
              "<tr>",
              "<td><a href='traitement.php?action=vider-panier'>
              <button type='button' class='btn btn-outline-danger'>Vider le panier</button></a>
              </td>",
              "</tr>",
            "</tbody>",
            "</table>",
          "</form>";
  }

  $content = ob_get_clean();

  $title = "Récapitulatif des produits";
  require "template.php";
