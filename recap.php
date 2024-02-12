<?php
//  cette page va permettre d'afficher la liste des produits présents
//  en session de manière organisée + le total de leur ensemble
//  il faudra pour ce faire parcourir le tableau de session, donc on
//  appelle la fct session_start() en début de fichier pour récupérer
//  la session utilisateur

session_start();

// ob_start();

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
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des produits</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href=" https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/minty/bootstrap.min.css " 
    rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
    crossorigin="anonymous"></script>
  </head>
<body>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">1ere Appli</a>
        <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse" data-bs-target="#navbarColor01"
        aria-controls="navbarColor01" aria-expanded="false"
        aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="./recap.php">
              <button type="button" class="btn btn-primary position-relative">
              Panier
              <span class="position-absolute top-0 start-100 translate-middle 
              badge rounded-pill bg-danger">
              <?= $totalProduits ?></p>
                <span class="visually-hidden">Panier</span>
              </span>
              </button>
              </a>
            </li>
          </ul>
        </div>
    </nav>
    <?php 
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

        // $content = ob_get_clean();

        // require_once "template.php";

    ?>
</body>
</html>