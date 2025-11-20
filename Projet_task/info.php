<?php
// Exercice 26
// Reprendre le projet Task avec la demo ci-dessus

// Le But : Ajouter une page sur le projet dont le but est d'enregistrer une Task en BDD.

// Les Contraintes :
// 1) L'accès à la page (le lien dans le menu navigation) ne doit s'afficher que pour les utilisateurs connecté
// 2) N'oubliez pas que la Task doit être relié à l'id de l'utilisateur connecté (dans la requête INSERT INTO, vous devrez donner une valeur pour la clé étrangère id_user)
// 3) Fait le tout en Model View Controller
// la page controller se nommera : task.php


//Démarer la Session
session_start();

//IMPORT DE RESSOURCE
include './Model/model_user.php';

//Variable d'affichage
$title = 'Mon Compte Utilisateur';

//TRAITEMENT DU FORMULAIRE DE MISE A JOUR
if(isset($_POST['update'])){
    $firstname = '';
    $lastname = '';
    if(!empty($_POST['firstname'])){
        $firstname = htmlentities(stripslashes(strip_tags(trim($_POST['firstname']))));
    }
    if(!empty($_POST['lastname'])){
        $lastname = htmlentities(stripslashes(strip_tags(trim($_POST['lastname']))));
    }

    //Création de l'objet de connexion
    $bdd = new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    updateUser($bdd,$firstname,$lastname,$_SESSION['id']);
}

include './View/header.php';

include './View/view_compte.php';

include './View/footer.php';

?>

