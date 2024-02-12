<?php
//  cette page va permettre d'afficher la liste des produits présents
//  en session de manière organisée + le total de leur ensemble
//  il faudra pour ce faire parcourir le tableau de session, donc on
//  appelle la fct session_start() en début de fichier pour récupérer
//  la session utilisateur

require_once "functions.php";

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
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
              <?= afficherTotalProduits(); ?>
                <span class="visually-hidden">Panier</span>
              </span>
              </button>
              </a>
            </li>
          </ul>
        </div>
    </nav>
    <div class="container">

        <?= $content ?>

    </div>
</body>
