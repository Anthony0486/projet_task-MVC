<?php
//MODIFIER UN COMPTE : ROUTE EN METHOD PUT

// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin:*");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée, ici PUT, mais ça peut être POST, GET ou DELETE
header("Access-Control-Allow-Methods: PUT");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] !== "PUT"){
    //Si la Requête n'utilise pas la méthode POST :
    //1) J'encode un code de réponse HTTP
    http_response_code(405); // 405 -> Code d'erreur pour : Méthode non autorisé

    //2) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Vous n'utilisez pas la bonne méthode PUT"]);

    //3) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}

$json = file_get_contents('php://input');
$data = json_decode($json);


if(empty($data->nom) || empty($data->prenom)){

    //Si l'un des champs est vide :
    //A) J'encode un code de réponse HTTP
    http_response_code(400); // 400 -> Code d'erreur pour : Mauvaise Requête (BAD REQUEST)

    //B) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Veuillez fournir tous les champs"]);

    //C) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}

$data->nom = htmlentities(strip_tags(stripslashes(trim($data->nom))));
$dat->prenom = htmlentities(strip_tags(stripslashes(trim($data->prenom))));

$bdd = new PDO('mysql:host=localhost;dbname=utilisateur','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        //Try Catch pour requête de Mise à jour
        try{
            //Requête préparée
            $req = $bdd->prepare('UPDATE users SET firstname_user = ?, lastname_user = ? WHERE id_user = ?');

            //Je récupère depuis l'objet les données à mettre à jour 
            $firstname = $data->nom;
            $lastname = $data->prenom;
            $id = $data->id;

            //Binding de Paramètre
            $req->bindParam(1,$firstname,PDO::PARAM_STR);
            $req->bindParam(2,$lastname,PDO::PARAM_STR);
            $req->bindParam(3,$id,PDO::PARAM_INT);

            //Execution de la requête
            $req->execute();

            //Réception de la réponse de la BDD
             $data = $req->fetch(PDO::FETCH_ASSOC);
        }catch(EXCEPTION $error){
            echo json_encode(["message" => $error->getMessage()]);
        }

    //A) J'encode un code de réponse HTTP
    http_response_code(200); // 200 -> Code d'erreur pour : OK

    //B) Envoie de la réponse
    echo json_encode(["message" => "$prenom $nom a été modifié en BDD"]);
    return;