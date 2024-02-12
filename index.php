<?php
// on appelle la fct session_start() en début de fichier pour récupérer
// la session utilisateur
// session_start();

// on démarre la temporisation de sortie
ob_start();



?>
    
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

      // on récupère (get) le contenu de la temporisation et on l'efface (clean);
      // et le contenu est stocké dans la variable $content
      $content = ob_get_clean();

      // on inclus le fichier template.php
      // cela équivaut à coller le code de template.php : $content est reconnue car instanciée
      // plus haut
      require_once "template.php";

      ?>
