<?php
//Démarer la Session
session_start();

//IMPORT DE RESSOURCE
include './Model/UsersModel.php';

//Variable d'affichage
$title = 'Mon Compte Utilisateur';
$style='./src/style/style-info.css';

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

