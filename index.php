<?php

session_start();

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
    <title>Ajout  produit</title>
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
        <a class="navbar-brand" href="#">1ere Appli</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarColor01" aria-controls="navbarColor01"
        aria-expanded="false" aria-label="Toggle navigation">
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
    <div class="container">
      <h1>Ajouter un produit</h1>
      <!-- attribut action : indique la cible du formulaire, le fichier a 
      atteindre lsq utilisateur soumettra le formulaire -->
      <!-- attribut method : précise par quelle méthode HTTP les données du formulaire 
      seront transmises au serveur -->
      <!--  ici: la method employée est POST pour ne pas polluer l'URL avec les 
      données du formulaire. Si aucune méthode n'est spécifiée, 
      la methode GET est utilisée. Les données renseignées
      dans les champs du formulaire sont donc inscrites dans l'URL avec cette méthode. -->
      <form action="traitement.php?action=ajouter" method="post" >
        <p>
            <label for="">
                <!-- Nom du produit :
                chaque input a un attribut "name", ce qui permet à 
                la requête de classer le contenu saisi dans les clés qui 
                portent les noms choisis. (ici: name, price, qtt)  -->
                <input type="text" name="name" class="form-control" 
                placeholder="Nom du produit">
            </label>
        </p>
        <p>
            <label for="">
                Prix du produit :
                <input type="number" name="price" class="form-control" 
                placeholder="Prix du produit">
            </label>
        </p>
        <p>
            <label for="">
                Quantité désirée :
                <input type="number" name="qtt" value="1" class="form-control" 
                placeholder="Quantitée désirée">
            </label>
        </p>
        <p>
            <!-- le input de type "submit" a aussi un attribut "name" : 
            cela permet à vérifier côté serveur que le formulaire a bien été 
            validé par l'utilisateur -->
            <button type="submit" name="submit" class="btn btn-outline-primary">
              Ajouter le produit
            </button>
        </p>
      </form>
      <?php
      // si dans la session il y a le tableau [message] (qu'on a crée ds fct ajouterProduit)
      if (isset($_SESSION['message'])) {
        // alors on affiche le tab
        echo $_SESSION['message'];
        // puis on détruit pour enlever l'affichage
        unset($_SESSION['message']);
      }
      ?>
    </div>
  </body>
</html>