<?php
//Fonction utilitaire de nettoyage
function sanitize($data){
    return htmlentities(strip_tags(stripslashes(trim($data))));
}
?>