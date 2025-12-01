<?php
//LECTURE DU COMPTE : ROUTE EN METHOD GET

/////////////////////////////
//  HEADER DE LA ROUTE :
/////////////////////////////

// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin:*");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée, ici GET, mais ça peut être POST, PUT ou DELETE
header("Access-Control-Allow-Methods: GET");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//////////////////////////////////
//  RECUPERATION DE A REQUETE
/////////////////////////////////

//On Teste la méthode la requête pour savoir si elle correspond bien à la méthode autorisée (ici GET)
if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    //Si la Requête n'utilise pas la méthode GET :
    //1) J'encode un code de réponse HTTP
    http_response_code(405); // 405 -> Code d'erreur pour : Méthode non autorisé

    //2) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    $json = json_encode(["message" => "Vous n'utilisez pas la bonne méthode GET"]);

    //3) J'envoie la réponse en effectuant son affichae
    print_r($json);
    return;
}

//METHODE AUTORISE
// JE LANCE L'ALGO POUR RETOURNER LA LSITE DES UTILISATEURS

//Récupération des données envoyé par le client via $_GET
//A) Les données GET sont rempli
if(empty($_GET['id'])){ //Si vide => erreur
    //1) J'encode un code de réponse HTTP
    http_response_code(400); //code erreur 400 -> mauvaise requête (ici incomplète car donnée obligatoire vide)

    //2) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    echo json_encode(["message" => "Donnée obligatoire ID vide"]);
    return;
}

//B) Vérification du format des données
if(!filter_var($_GET['id'], FILTER_VALIDATE_INT)){
    //1) J'encode un code de réponse HTTP
    http_response_code(400); //code erreur 400 -> mauvaise requête (ici incomplète car donnée pas au bon format)

    //2) J'encode la réponse (qui est en tableau associatif) sous forme de JSON
    echo json_encode(["message" => "ID pas au bon format"]);
    return;
}


//C) Nettoyage de la donnée
$id = htmlentities(strip_tags(stripslashes(trim($_GET['id']))));

//1) Je dois créer l'objet de connexion PDO
try{
    $bdd = new PDO('mysql:host=localhost;dbname=utilisateur','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //2) Préparation de la requête
    $req = $bdd->prepare('SELECT id, nom, prenom, email, dob FROM utilisateurs WHERE id= ?');

    //2.1)Binding de Param
    $req->bindParam(1,$id,PDO::PARAM_INT);

    //3) Execution de la requête
    $req->execute();

    //4) Récupération des utilisateurs
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    //5) Encode le code de réponse HTTP
    http_response_code(200); // code response 200 -> OK, tout s'est bien passé

    //6) Encodage des données en json
    $response = json_encode($data);

    //7) Envoie des données en faisant leur affichae
    echo $response;
    return;
}catch(EXCEPTION $error){
    die($error->getMessage());
}