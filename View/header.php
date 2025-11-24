<!DOCTYPE html>
<html lang="en">
<head>
    

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo $style ?>">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Accueil General</a></li>
                <?php 
                    switch($title){
                        case 'Mon Compte Utilisateur' :
                        case 'Mes ToDoes' :
                            echo "<li><a href='./index.php'>Accueil TODO LIST</a></li>";
                            break;
                        case 'accueil TODO LIST' :
                            echo "<li><a href='./info.php'>Vos Infos</a></li>";
                            break;
                    }

                    if(isset($_SESSION['nickname'])){
                        echo "<li><a href='./task.php'>My ToDoes</a></li>";
                        echo "<li><a href='./deco.php'>Se Deconnecter</a></li>";
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

 