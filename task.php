<?php
//Démarrage de la Session
session_start();

//Importer les Ressources
include './Model/TaskModel.php';
include './Model/CategoryModel.php';
include './utils/functions.php';

//Initialisation des variables d'affichages
$title = "Mes ToDoes";
$style = "./src/style/style-todo.css";
$message = "";
$checkboxCategories = '';
$todoList = '';

//Traitement de l'affichage des Categories dans le formulaire
//1) Création de l'objet de connexion PDO
$bdd = new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

//2) Lancer la requête SELECT via le model
$data = readCategroires($bdd);

//3) Créer la liste des checkbox pour le formulaire
foreach($data as $category){
    $checkboxCategories = $checkboxCategories."<input id='{$category['category']}' type='checkbox' name='category[]' value='{$category['id_category']}'><label for='{$category['category']}'> {$category['category']} </label>";
}

//Le Traitement le formulaire d'Ajout d'une Task
//1) Vérifier la réception du formulaire
if(isset($_POST['addTask'])){
   //2) Sécurité : Vérifier les champs vides
   if(!empty($_POST['nameTask']) && !empty($_POST['contentTask']) && !empty($_POST['dateTask']) && !empty($_POST['category'])){
        //3) Sécurité : vérifier le format des données -> pas de format à valider (sauf utilisation de REGEX)
        //booléen à true pour gérer le format des checkbox
        $bool = true;
        //boucle sur le tableau de checkbox
        foreach($_POST['category'] as $category){
            //Si au moins une checkbox n'est pas un entier naturel, alors je mets le booléen à false
            if(!filter_var($category, FILTER_VALIDATE_INT)){
                $bool = false;
            }
        }
        //Bool = true si checkbox au bon format
        if($bool){
            //4) Sécurité : nettoyer les données
            $name = sanitize($_POST['nameTask']);
            $content = sanitize($_POST['contentTask']);
            $date = sanitize($_POST['dateTask']);
            //Nettoyage du tableau de checkbox
            $tabCategory = [];
            foreach($_POST['category'] as $category){
                array_push($tabCategory,sanitize($category));
            }

            //5) Créer un objet de connexion PDO
            $bdd = new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            //6) J'appelle le Model pour créer la Task
            //7) J'affiche le message de confirmation
            $message = createTask($bdd, $name, $content, $date, $_SESSION['id'], $tabCategory);
        }else{//Else checkbox pas au bon format
            $message = "Checkbox pas au bon format !";
        }

   }else{
        $message = "Veuillez remplir tous les champs !";
   }
}

//Traiter l'affichage des Task
//1) Création de l'objet de connexion à la BDD
// -> déjà fait tout au début du fichier

//2) Lancer la récupération de la liste des Task en BDD
$data = readTasksByUser($bdd,$_SESSION['id']);

//3) Comme je reçois un tableau de Task, traiter le tableau avec une boucle pour générer un affichage (card Task) à mettre dans $todoList
foreach($data as $task){
    $todoList = $todoList."<article>
        <h3> {$task['name_task']} </h3>
        <h4> DATE : {$task['date_task']} </h4>
        <h5> Categories : {$task['categories']}</h5>
        <p>{$task['content_task']}</p<
    </article>";
}

//Affichage de la vue
include './View/header.php';

include './View/view_task.php';

include './View/footer.php';