<?php

//Destruction de la session
session_destroy();

//Redirection HTTP
header('/projet_task/accueil');

?>