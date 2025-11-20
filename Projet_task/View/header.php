<!DOCTYPE html>
<html lang="en">
<head>
    

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <?php 
                    switch($title){
                        case 'Mon Compte Utilisateur' :
                            echo "<li><a href='./index.php'>Accueil</a></li>";
                            break;
                        case 'accueil' :
                            echo "<li><a href='./info.php'>Vos Infos</a></li>";
                            break;
                        case 'Mes tâches' :
                            echo "<li><a href='./index.php'>Accueil</a></li>";
                            echo "<li><a href='./info.php'>Vos Infos</a></li>";
                            break;

                    }

                    if(isset($_SESSION['nickname'])){
                        echo "<li><a href='./deco.php'>Se Deconnecter</a></li>";
                        echo "<li><a href='./task.php'>Mes tâches</a></li>";

                    }
                ?>
                
            </ul>
        </nav>
            <?php
                if(isset($_SESSION['nickname'])){
                    echo "<span>Vous êtes : {$_SESSION['nickname']}</span>";
                }
            ?>
    </header>
    <main>

 