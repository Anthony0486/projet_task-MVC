<?php




function createTask($bdd,$nameTask,$contentTask,$id){
    //Try Catch pour requête de Mise à jour
    try{
        //Requête préparée
        $req = $bdd->prepare('INSERT INTO task (name_task, content_task, id_user) VALUES (?, ?, ?)');

        //Binding de Paramètre
        $req->bindParam(1,$nameTask,PDO::PARAM_STR);
        $req->bindParam(2,$contentTask,PDO::PARAM_STR);
        $req->bindParam(3,$id,PDO::PARAM_INT);

        //Execution de la requête
        $req->execute();

        //Retourner un message de confirmation
        return "Tâche créee avec succès";

    }catch(EXCEPTION $error){
        die($error->getMessage());
    }
}



?>