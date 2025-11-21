<?php

function createTask($bdd, $nameTask, $contentTask, $dateTask, $id){
    //Try Catch pour requête de Mise à jour
    try{
        //Requête préparée
        $req = $bdd->prepare('INSERT INTO task (name_task, content_task, date_task, id_user) VALUES (?, ?, ?, ?)');

        //Binding de Paramètre
        $req->bindParam(1,$nameTask,PDO::PARAM_STR);
        $req->bindParam(2,$contentTask,PDO::PARAM_STR);
        $req->bindParam(3,$dateTask,PDO::PARAM_STR);
        $req->bindParam(4,$id,PDO::PARAM_INT);

        //Execution de la requête
        $req->execute();

        $data = $req->fetchAll();

        $messageTask = "Votre tâche a bien été enregistrée";
        //Retourner un message de confirmation
        return ['data' => $data, 'message' => $messageTask];

    }catch(EXCEPTION $error){
        die($error->getMessage());
    }
}

?>