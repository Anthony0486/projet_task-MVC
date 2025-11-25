<?php
//Démarer la Session
session_start();

//IMPORT DE RESSOURCE
include './Model/UsersModel.php';
include './utils/functions.php';

//Variable d'affichage
$title = 'Mon Compte Utilisateur';
$style='./src/style/style-info.css';
$message = '';

//TRAITEMENT DU FORMULAIRE DE MISE A JOUR
if(isset($_POST['update'])){
    $firstname = '';
    $lastname = '';

    if(!empty($_POST['firstname'])){
        $firstname = sanitize($_POST['firstname']);
    }
    if(!empty($_POST['lastname'])){
        $lastname = sanitize($_POST['lastname']);
    }

    //Création de l'objet de connexion
    $bdd = new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //Création de l'objet Users à partir de la class Users
    $user = new Users($bdd);

    //Je remplis mon objet avec les données dont j'ai besoin
    $user->setFirstname($firstname)->setLastname($lastname)->setIdUser($_SESSION['id']);

    //J'utilise la méthode de l'objet updateUser() pour qu'il mette à jour les données de mon utilisateur en BDD
    $message = $user->updateUser();
}

include './View/header.php';
$header = new Header();
echo $header->setTitle($title)->setStyle($style)->renderHeader();

include './View/view_compte.php';

include './View/footer.php';
$footer = new Footer();
echo $footer->renderFooter();

?>

