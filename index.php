<?php
session_start();

include './utils/functions.php';
include './Model/UsersModel.php';
include './Model/TaskModel.php';
include './Model/CategoryModel.php';
include './View/header.php';
include './View/footer.php';

$url = parse_url($_SERVER['REQUEST_URI']);

// var_dump($url); 
$path = '';

if(isset($url['path'])){
    $path = $url['path'];
}else{
    $path = '/projet_task/';
}

switch($path){
    case '/projet_task/':
    case '/projet_task/accueil':
        include './View/view_accueil.php';
        include './Controler/accueil.php';
        $accueil = new AccueilController();
        $accueil->displayAccueil();
        break;
    case '/projet_task/moncompte':
        include './View/view_compte.php';
        include './Controler/infoControler.php';
        $info = new InfoController();
        echo $info->displayInfo();
        break;
    case '/projet_task/mestaches':
        include './Controler/task.php';
        break;
    case '/projet_task/deco':
        include './Controler/deco.php';
        break;
    default : 
        include './Controler/404.php';
        break;
}

?>