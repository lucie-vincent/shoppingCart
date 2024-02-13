<?php
// pour enregistrer les produits en session sur le serveur, on effectue
// l'appel d'une fonction qui permet : 1. de démarrer une session sur le
// serveur pour l'utilisateur courant 2. de récupérer la session de cet
// utilisateur s'il en avait une (possible grâce au cookie PHPSESSID)
// enregristré par le serveur dans le navigateur client

session_start();

// if (isset($_FILES['file'])) {
//     $tamponNom  = $_FILES['file']['tmp_name'];
//     $name       = $_FILES['file']['name'];
//     $size       = $_FILES['file']['size'];
//     $error      = $_FILES['file']['error'];
// }


if (isset($_GET['action'])) {
    
    // nettoyage de "id" reçu en GET
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    
    switch($_GET['action']) {
        // on vérifie le paramètre de l'action
        case "ajouter" :
            // on appelle la fonction liée à cette action
            ajouterProduit();
            break;
            case "vider-panier":
                viderPanier();
                break;
                case "supprimer-produit":
                    supprimerProduit($id);
                    break;
                    case "modifier-qtt":
                        // on vérifie si l'action contient également 'augmenter'
                        if (isset($_GET['augmenter'])) {
                            // on récupère la valeur du paramètre et on le convertit en booléen
                            $augmenter = ($_GET['augmenter'] == 'true');
                // on appelle la fonction avec le booléen en paramètre, qui va effectuer 
                // l'action selon si $augmenter est vrai ou faux
                modifierQtt($id, $augmenter);
            }
            
            break;
        }
}
    

    
function ajouterProduit() {
    // pour éviter à un utilisateur mal intentionné d'atteindre le fichier traitement.php
    // en tapant simplement l'url dans la barre d'adresse, on limite son accès:
    // accès seulement si les requêtes HTTP proviennent de la soumission
    // du formulaire
    
    
    // isset : détermine si une variable est déclarée et est différente de null
    // puis on vérifie l'existence de la clé submit dans le tableau $_POST
    // la condition est vraie si la requête POST transmet 1 clé submit au serveur
    if (isset($_POST['submit']) && isset($_FILES['file'])) {
        // pour éviter les failles par injection de code, on vérifie l'intégrité
        // des valeurs transmises dans le tableau $_POST
        
        // filter_input renvoie en cas de succès la valeur assainie correspondant
        // au champ traité, false si filtre échoue ou null si champ n'existait pas dans
        // la requete
        
        // pour le champ name : supprime les caratères spéciaux et balises 
        // HTML des chaines de caractères
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // pour le champ price : valide le prix uniquement si nombre à virgule 
        // (pas de string)
        // permet le "," ou "." pour la décimale
        $price = filter_input(INPUT_POST,"price", FILTER_VALIDATE_FLOAT, 
        FILTER_FLAG_ALLOW_FRACTION);
        
        // pour le champ qtt : valide la quantité uniquement si nombre entier
        // différent de 0 (considéré comme nul)
        $qtt = filter_input(INPUT_POST,"qtt", FILTER_VALIDATE_INT);
        
        // traitement image
        $tmpName  = $_FILES['file']['tmp_name'];
        $imgName  = $_FILES['file']['name'];
        $size     = $_FILES['file']['size'];
        $error    = $_FILES['file']['error'];
      
      
        // pomme.jpg
        // ['pomme', 'jpg']
        $tabExtension = explode('.', $imgName);
        $extension = strtolower(end($tabExtension));
      
        // tableau des extensions autorisées
        $extensionsAutorisees = ['jpg', 'jpeg', 'gif', 'png'];
        
        $tailleMax = 400000;
      
        // var_dump(in_array($extension, $extensionsAutorisees));
        // var_dump($size <= $tailleMax);
        // var_dump($error == 0);
        // var_dump($size);
            
        if(in_array($extension, $extensionsAutorisees) && $size <= $tailleMax && $error == 0) {
          // pouvoir ajouter des fichiers avec même nom : on crée nom unique
        //   $uniqueName = uniqid('', true);
        //   $fileName = $uniqueName. '.' .$extension;
        //   var_dump($fileName);
          
          // choisir l'endroit enregitrement image
          move_uploaded_file($tmpName,'./upload/'.$imgName);
      
        }
        else {
          echo "Mauvaise extension ou taille trop importante ou erreur";
        }


        // on vérifie si les filtres ont bien fonctionné grâce à une nouvelle condition
        // pas de comparaison dans la condition car on vérifie si non null ou false
        if ($name && $price && $qtt) {
            // on crée un tableau associatif $product
            $product = [
                "name" => $name,
                "price" => $price,
                "qtt" => $qtt,
                "total" => $price*$qtt,
                "tmpName" => $tmpName,
                "imgName" =>$imgName,
                "size" =>$size,
                "error" =>$error,
            ];
            
            // on enregistre le tableau $products dans le tableau de session
            // $_SESSION
            // on sollicite le tableau de session $_SESSION et on indique la clé
            // products de ce tableau; si elle n'existait pas, php la crée.
            // les [] indiquent qu'on ajoute une nouvelle entrée au futur tableau
            // products associé à cette clé.
            $_SESSION['products'][] = $product;
            $_SESSION['message'] = "produit ajouté";
            
        }

    }
    
    // envoie une nouvelle entête HTTP au client. Le type d'appel : Location
    header("Location:index.php");
    die();
}

function supprimerProduit($id) {
    //  si le produit existe bien en SESSION
    if (isset($_SESSION['products'][$id])) {
        // si le produit est supérieur à 1
        if ($_SESSION['products'][$id] > 1) {
            // on supprime le produit
            unset($_SESSION['products'][$id]);
        }
    }
    header("Location:recap.php");
    die();
}

function viderPanier() {
    // unset() : détruit la ou les variables passées en argument
    unset($_SESSION['products']);
    header("Location:recap.php");
    die();
}

// pour mofifier la qté, on ajoute un booléen qui indique si la quantité doit être augmentée ou diminuée
function modifierQtt($id, $augmenter = true) {
    // on vérifie si le produit est bien dans le panier
    if (isset($_SESSION['products'][$id])) {
        // on vérifie si on veut augmenter
        if ($augmenter == true) {
            // alors on augmente la qté
            $_SESSION['products'][$id]['qtt']++;
        } else { // si on ne veut pas augmenter
            // si la qté est sup à 1
            if($_SESSION['products'][$id]['qtt'] > 1) {
                // on diminue
                $_SESSION['products'][$id]['qtt']--;
            } else { // si la qté est égale à 1 on supprime car le produit ne peut pas avoir qté négative
                unset($_SESSION['products'][$id]);
            }
        }
    }
    header("Location:recap.php");
    die();
}


// function augmenterQtt($id) {
//     // si le produit existe bien en SESSION
//     if (isset($_SESSION['products'][$id])) {
//         // on augmente de 1 à sa quantité
//         $_SESSION['products'][$id]['qtt']++;
//     }
// }

// function diminuerQtt($id) {
//     // si le produit existe bien en SESSION
//     if (isset($_SESSION['products'][$id])) {
//         if ($_SESSION['products'][$id] >= 1) {
//         // on diminue de 1 sa quantité
//             $_SESSION['products'][$id]['qtt']--;
//         } else { // si la quantité est égale ou inférieur à 1
//             // on supprime le produit
//             unset($_SESSION['products'][$id]);
//         } 
//     } 
// }

// header()
// indique une redirection (statut 302)
// !! pour utiliser header :
// 1.on ne peut pas afficher du html avant, ou ou appeler une fonction
// print() ou echo()
// 2. il faut que le header soit la dernière instruction ou appeler
// exit() ou die() car sinon tout ce qui suit sera exécuté
