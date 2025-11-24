<?php
//Demarrer la session
session_start();

//Destruction de la session
session_destroy();

//Redirection HTTP
header('location:./index.php');

?>