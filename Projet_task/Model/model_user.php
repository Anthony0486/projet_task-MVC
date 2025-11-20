<?php
function readUserByNicknameAndEmail($bdd, $nickname, $email){
    try{
                    //Prepare
                    $req = $bdd->prepare('SELECT u.id_user, u.nickname_user, u.email_user, u.firstname_user, u.lastname_user, u.password_user, r.id_role, r.`role` FROM users u INNER JOIN `role` r ON u.id_role = r.id_role WHERE u.nickname_user = ? OR u.email_user = ?');

                    //BindParam
                    $req->bindParam(1,$nickname,PDO::PARAM_STR);
                    $req->bindParam(2,$email,PDO::PARAM_STR);

                    //Execute
                    $req->execute();

                    //$data = FetchAll
                    $data = $req->fetchAll();

                    //[TEST] : Ici j'affiche la réponse de la BDD pour TESTER si ma requête fonctionne comme voulu
                    echo "Print_r(\$data) pour savoir ce qu'il y a dedans </br>";
                    print_r($data);

                    return $data;

                }catch(EXCEPTION $error){
                    die($error-getMessage());
                }
}

function readUserByNickname($bdd, $nickname){
    try{
            //Préparer la requête à envoyer
            $req = $bdd->prepare('SELECT u.id_user, u.nickname_user, u.email_user, u.firstname_user, u.lastname_user, u.password_user, r.id_role, r.`role` FROM users u INNER JOIN `role` r ON u.id_role = r.id_role WHERE u.nickname_user = ? LIMIT 1');

            //Binding de Paramètre
            $req->bindParam(1,$nickname,PDO::PARAM_STR);

            //Exécuter la requête
            $req->execute();

            //Récupérer la réponse de la BDD
            $data = $req->fetch();

            return $data;
        }catch(EXCEPTION $error){
            die($error->getMessage());
        }
}

function createUser($bdd,$nickname,$email,$password){
    try{
                        //ETAPE 6.2 : Vérifier si le Pseudo et l'Email sont disponible. Former la requête à envoyer
                        $req = $bdd->prepare("INSERT INTO users (nickname_user, email_user, password_user, id_role) VALUES (?,?,?, 2)");

                        //ETAPE 6.3 : Binding de Paramètre -> relier chaque ? de la requête à une valeur
                        //1er paramètre : position du ? dans la requête
                        //2nd paramètre : valeur à insérer dans la requête
                        //3eme paramètre : format du paramètre (classiquement : STRING ou INT)
                        $req->bindParam(1,$nickname,PDO::PARAM_STR);
                        $req->bindParam(2,$email,PDO::PARAM_STR);
                        $req->bindParam(3,$password,PDO::PARAM_STR);

                        //Etape 6.3 : Envoyer la requête
                        $req->execute();

                        //Etape 6.4 : Récupérer la réponse
                        $data = $req->fetchAll();

                        //Etape 6.5 : Message de confirmation
                        $message = "$nickname a été enregistré avec succès !";

                        return ['data' => $data, 'message' => $message];

                    }catch(EXCEPTION $error){
                        die($error->getMessage());
                    }
}

function updateUser($bdd,$firstname,$lastname,$id){
    //Try Catch pour requête de Mise à jour
    try{
        //Requête préparée
        $req = $bdd->prepare('UPDATE users SET firstname_user = ?, lastname_user = ? WHERE id_user = ?');

        //Binding de Paramètre
        $req->bindParam(1,$firstname,PDO::PARAM_STR);
        $req->bindParam(2,$lastname,PDO::PARAM_STR);
        $req->bindParam(3,$id,PDO::PARAM_INT);

        //Execution de la requête
        $req->execute();

        //Retourner un message de confirmation
        return "Mise à jour effectué avec succès";

    }catch(EXCEPTION $error){
        die($error->getMessage());
    }
}
?>