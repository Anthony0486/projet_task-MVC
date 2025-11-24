<?php
function readCategroires($bdd){
    try{
        //PRéparation de la requête
        $req = $bdd->prepare('SELECT c.id_category, c.category FROM category c');

        //Executer la requête
        $req->execute();

        //Retourne la réponse de la BDD
        return $req->fetchAll();
    }catch(EXCEPTION $error){
        die($error->getMessage());
    }
}