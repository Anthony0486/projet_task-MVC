<?php
//ENREGISTRER UN COMPTE EN BDD : ROUTE EN METHOD POST

/////////////////////////////
//  HEADER DE LA ROUTE :
/////////////////////////////

// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin:*");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée, ici POST, mais ça peut être GET, PUT ou DELETE
header("Access-Control-Allow-Methods: POST");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//////////////////////////////////
//  RECUPERATION DE A REQUETE
/////////////////////////////////

//On Teste la méthode la requête pour savoir si elle correspond bien à la méthode autorisée (ici POST)
if($_SERVER['REQUEST_METHOD'] !== "POST"){
    //Si la Requête n'utilise pas la méthode POST :
    //1) J'encode un code de réponse HTTP
    http_response_code(405); // 405 -> Code d'erreur pour : Méthode non autorisé

    //2) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Vous n'utilisez pas la bonne méthode POST"]);

    //3) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}

//JE VAIS LANCER LA PROCEDURE D'ENREGISTREMENT
//1) Je récupère le JSON au sein du body de la requête
$json = file_get_contents('php://input');

//2) Je convertie / decode le JSON
$data = json_decode($json);

//3) Je vérifie les données vides : nom, prenom, pseudo, email, mot de passe, dob (day of birth)
if(empty($data->nom) || empty($data->prenom) || empty($data->pseudo) || empty($data->email) || empty($data->password) || empty($data->dob)){

    //Si l'un des champs est vide :
    //A) J'encode un code de réponse HTTP
    http_response_code(400); // 400 -> Code d'erreur pour : Mauvaise Requête (BAD REQUEST)

    //B) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Veuillez fournir tous les champs"]);

    //C) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}

//4) Je vérifie le format des données
if(!filter_var($data->email,FILTER_VALIDATE_EMAIL)){
    //Si l'un des champs est vide :
    //A) J'encode un code de réponse HTTP
    http_response_code(400); // 400 -> Code d'erreur pour : Mauvaise Requête (BAD REQUEST)

    //B) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Veuillez fournir un email au bon format"]);

    //C) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}



//5) Je nettoyez les données
$nom = htmlentities(strip_tags(stripslashes(trim($data->nom))));
$prenom = htmlentities(strip_tags(stripslashes(trim($data->prenom))));
$pseudo = htmlentities(strip_tags(stripslashes(trim($data->pseudo))));
$password = htmlentities(strip_tags(stripslashes(trim($data->password))));
$email = htmlentities(strip_tags(stripslashes(trim($data->email))));
$dob = htmlentities(strip_tags(stripslashes(trim($data->dob))));

// //6) Je vais hasher le password
$password = password_hash($password,PASSWORD_DEFAULT);

//7) Je vérifie que l'emai lde l'utilisateur n'existe pas déjà en BDD (car email en UNIQUE)
//7.1) Création du PDO
$bdd = new PDO('mysql:host=localhost;dbname=utilisateur','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

//7.2) Préparation de la requête
try{
    $req = $bdd->prepare('SELECT id, nom, prenom, pseudo, email, dob, mdp FROM utilisateurs WHERE email = ? LIMIT 1');

    //7.3)Binding de param
    $req->bindParam(1,$email,PDO::PARAM_STR);

    //7.4) Execution de la requête
    $req->execute();

    //7.5) Réception de la réponse de la BDD
    $data = $req->fetch(PDO::FETCH_ASSOC);
}catch(EXCEPTION $error){
    echo json_encode(["message" => $error->getMessage()]);
}

//7.6) Je vérifie la réponse
if(!empty($data)){
    //Si l'email est déjà utilisé :
    //A) J'encode un code de réponse HTTP
    http_response_code(400); // 400 -> Code d'erreur pour : Mauvaise Requête (BAD REQUEST)

    //B) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Cet email est déjà utilisé"]);

    //C) J'envoie la réponse en effectuant son affichae
    echo $json;
    return;
}

//8) Lancer l'enregistrement en BDD
try{
    //8.1) Préparation de la requête
    $req = $bdd->prepare('INSERT INTO utilisateurs (nom, prenom, pseudo, email, mdp, dob) VALUES (?,?,?,?,?,?)');

    //8.2)Binding de param
    $req->bindParam(1,$nom,PDO::PARAM_STR);
    $req->bindParam(2,$prenom,PDO::PARAM_STR);
    $req->bindParam(3,$pseudo,PDO::PARAM_STR);
    $req->bindParam(4,$email,PDO::PARAM_STR);
    $req->bindParam(5,$password,PDO::PARAM_STR);
    $req->bindParam(6,$dob,PDO::PARAM_STR);

    //8.3) Execution de la requête
    $req->execute();

}catch(EXCEPTION $error){
    echo json_encode(["message" => $error->getMessage()]);
}

//A) J'encode un code de réponse HTTP
http_response_code(200); // 200 -> Code d'erreur pour : OK

//B) Envoie de la réponse
echo json_encode(["message" => "$prenom $nom a été enregistré en BDD"]);
return;