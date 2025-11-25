<?php
//Démarer la Session
session_start();

//IMPORT DE RESSOURCE
include './Model/UsersModel.php';
include './utils/functions.php';

//Variable d'affichage
$title = 'Mon Compte Utilisateur';
$style='./src/style/style-info.css';

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
    $user = new Users($bdd);
    $user->setIdUser($_SESSION['id'])
    ->$user->setFirstname($firstname)
    ->$user->setLastname($lastname)
    ->$user->updateUser();
}

include './View/header.php';

include './View/view_compte.php';

include './View/footer.php';

?>

