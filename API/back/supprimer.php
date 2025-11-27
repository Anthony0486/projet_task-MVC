<?php
//SUPPRIMER UN COMPTE : ROUTE EN METHOD DELETE

header("Access-Control-Allow-Origin:*");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée, ici DELETE, mais ça peut être GET, PUT ou POST
header("Access-Control-Allow-Methods: DELETE");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] !== "DELETE"){
    //Si la Requête n'utilise pas la méthode POST :
    //1) J'encode un code de réponse HTTP
    http_response_code(405); // 405 -> Code d'erreur pour : Méthode non autorisé

    //2) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Vous n'utilisez pas la bonne méthode DELETE"]);

    //3) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}

$json = file_get_contents('php://input');
$data = json_decode($json);

if(empty($data->password)){

    //Si l'un des champs est vide :
    //A) J'encode un code de réponse HTTP
    http_response_code(400); // 400 -> Code d'erreur pour : Mauvaise Requête (BAD REQUEST)

    //B) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Veuillez tapper votre mot de passe"]);

    //C) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}









//Nettoyage des données
  $password = htmlentities(strip_tags(stripslashes(trim($data->password))));

$bdd = new PDO('mysql:host=localhost;dbname=utilisateur','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$id = $_SESSION['id'];
try{
    $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ? LIMIT 1');

    //7.3)Binding de param
    $req->bindParam(1,$id,PDO::PARAM_STR);

    //7.4) Execution de la requête
    $req->execute();

    //7.5) Réception de la réponse de la BDD
    $data = $req->fetch(PDO::FETCH_ASSOC);
}catch(EXCEPTION $error){
    echo json_encode(["message" => $error->getMessage()]);
}

//A) J'encode un code de réponse HTTP
http_response_code(200); // 200 -> Code d'erreur pour : OK

//B) Envoie de la réponse
echo json_encode(["message" => "$prenom $nom a été enregistré en BDD"]);
return;