<?php
//Function pour enregistrer une Task
function createTask($bdd, $name, $content, $date, $id, $tabCategory){
    try{
        //Preparation de la requête
        $req = $bdd->prepare('INSERT INTO task (name_task, content_task, date_task, id_user) VALUES (?,?,?,?)');

        //Binding de Paramètre
        $req->bindParam(1,$name,PDO::PARAM_STR);
        $req->bindParam(2,$content,PDO::PARAM_STR);
        $req->bindParam(3,$date,PDO::PARAM_STR);
        $req->bindParam(4,$id,PDO::PARAM_INT);

        //Executer la requête
        $req->execute();

        //2)SELECT pour récupérer l'id de la task enregistrée
        $req = $bdd->prepare('SELECT t.id_task FROM task t WHERE t.id_user = ? ORDER BY t.id_task DESC LIMIT 1');

        $req->bindParam(1,$id,PDO::PARAM_INT);

        $req->execute();

        $idTask = $req->fetch();

        //3)Boucle d'INSERT INTO pour remplir la table task_category
        foreach($tabCategory as $idCategory){
            $req = $bdd->prepare('INSERT INTO task_category (id_task, id_category) VALUES (?,?)');

            $req->bindParam(1,$idTask[0],PDO::PARAM_INT);
            $req->bindParam(2,$idCategory,PDO::PARAM_INT);

            $req->execute();
        }

        //Retourner un message de confirmation
        return "$name a été ajouté à la liste des ToDoes";

    }catch(EXCEPTION $error){
        die($error->getMessage());
    }
}

function readTasksByUser($bdd,$id){
    try{
        //Preparation de la requête
        $req = $bdd->prepare('SELECT t.id_task, t.name_task, t.content_task, t.date_task, GROUP_CONCAT(c.category) categories FROM task t LEFT JOIN task_category tc ON t.id_task = tc.id_task LEFT JOIN category c ON tc.id_category = c.id_category WHERE t.id_user = ? GROUP BY t.id_task');

        //Binding de Param
        $req->bindParam(1,$id,PDO::PARAM_INT);

        //Execution de la requête
        $req->execute();

        //Récupérer la réponse de la bdd
        $data = $req->fetchAll();

        //Retourner les données
        return $data;
    }catch(EXCEPTION $error){
        die($error->getMessage());
    }
}