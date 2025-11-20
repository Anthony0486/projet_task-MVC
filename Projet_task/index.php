<?php
//Démarrer la session
session_start();

//IMPORT DE RESSOURCE
include './Model/model_user.php';

//Initialiser ma variable d'affichage
$title = 'accueil TODO LIST';
$message = '';
$messageCo = '';

//FROMULAIRE INSCRIPTION
//Vérifier que l'on reçoit le formulaire d'inscription
if(isset($_POST['signIn'])){
    //Etape de Sécurité 1 : vérifier les champs vides
    if(!empty($_POST['nickname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordVerify']) ){

        //Etape de Sécurité 2 : Vérifier le format des données
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            //ETAPE de Sécurité 3 : Nettoyage des données
            $nickname = htmlentities(stripslashes(strip_tags(trim($_POST['nickname']))));
            $email = htmlentities(stripslashes(strip_tags(trim($_POST['email']))));
            $password = htmlentities(stripslashes(strip_tags(trim($_POST['password']))));
            $passwordVerify = htmlentities(stripslashes(strip_tags(trim($_POST['passwordVerify']))));

            //Etape 4 : Vérifier la correspondance des mots de passe
            if($password === $passwordVerify){

                //Etape 5 : Hasher le mot de passe à enregistrer
                $password = password_hash($password, PASSWORD_DEFAULT);

                //ETAPE 6 : COMMUNICATION AVEC LA BDD
                //Etape 6.1 : Création de l'objet de connexion PDO
                $bdd = new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

                // => EXERCICE 24
                //Try...Catch -> D'envoyer une requête SELECT pour récupére les utilisateurs qui possèdent le même pseudo et le même email que ceux entrer
                $data = readUserByNicknameAndEmail($bdd, $nickname,$email);

                //Vérification des $data
                if(empty($data)){
                    //$data vide -> signifie que nickname et email sont dispo
                    // Lance le try... catch d'inscription
                    // Try... Catch : nous permet de gérer les erreurs de communication avec la BDD et de requête envoyée à la BDD
                    $data = createUser($bdd,$nickname,$email,$password);

                    //$data = [
                    //          '$data' => [tab de reponse de la bdd],
                    //          'message' => 'message créer dans la fonction create'
                    //         ]

                    //Affichage du message de confirmation
                    $message = $data['message'];
                }else{
                    //$data non vide -> signifie que nickname OU email indispo
                    //message d'erreur
                    $message = 'Pseudo ou Email indisponible.';
                }
                

            }else{
                $message = "Vos mots de passe ne sont pas identiques";
            }

        }else{
            $message = "Veuillez entrer un email valide";
        }

    }else{
        $message = "Veuillez remplir tous les champs";
    }
}

//FORMULAIRE
//Vérifier que l'on reçoit le formulaire de Connexion
if(isset($_POST['signUp'])){
    //Etape de Sécurité 1 : Vérifier les champs vides
    if(!empty($_POST['nicknameSignUp']) && !empty($_POST['passwordSignUp'])){
        //Etape de Sécurité 2 : Vérifier le Format -> aucun format à vérifier ici sauf utilisé une Regex
        //Etape de Sécurité 3 : Nettoyage des données
        $nickname = htmlentities(stripslashes(strip_tags(trim($_POST['nicknameSignUp']))));
        $password = htmlentities(stripslashes(strip_tags(trim($_POST['passwordSignUp']))));

        //Créer l'objet de connexion PDO
        $bdd = new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        //Try...catch pour communiquer avec la BDD :
        $data = readUserByNickname($bdd,$nickname);

        echo "Print_r(\$data) pour savoir ce qu'il y a dedans </br>";
        print_r($data);

        if(!empty($data)){
            //$data non vide, donc je reçois le compte de l'utilisateur
            //Vérifier la correspondancedes mots de psse : password_verify()
            if(password_verify($password, $data['password_user'])){
                //Je connecte l'utilisateur en remplissant la superglobal $_SESSION
                $_SESSION = [
                        'id' => $data['id_user'],
                        'nickname' => $data['nickname_user'],
                        'email' => $data['email_user'],
                        'role' => $data['role']
                ];

                //J'affiche le message de confirmation
                $messageCo = "{$_SESSION['nickname']} est connecté";

            }else{
                $messageCo = "Problème de Login et/ou Mot de Passe";
            }
        }else{
            //$data vide -> l'utilisateur n'existe pas -> message d'erreur
            $messageCo = "Problème de Login et/ou Mot de Passe";
        }

        

    }else{
        $messageCo = "Veuillez remplir tous les champs !";
    }

}


include './View/header.php';

include './View/view_accueil.php';
        
include './View/footer.php';
?>
