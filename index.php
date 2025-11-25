<?php
//Démarrer la session
session_start();

//IMPORT DE RESSOURCE
include './utils/functions.php';
include './Model/UsersModel.php';
include './View/header.php';
include './View/view_accueil.php';
include './View/footer.php';

class AccueilController{
    //ATTRIBUTS
    private string $title = 'accueil TODO LIST';
    private string $style='./src/style/style-accueil.css';
    private string $message = '';
    private string $messageCo = '';
    private Users $model;
    private Header $header;
    private AccueilView $accueil;
    private Footer $footer;

    //CONSTRUCTEUR
    public function __construct(){
        $this->model = new Users(new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)));

        $this->header = new Header();
        $this->accueil = new AccueilView();
        $this->footer = new Footer();
    }

    //GETTER ET SETTER
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }

    public function getStyle(): string { return $this->style; }
    public function setStyle(string $style): self { $this->style = $style; return $this; }

    public function getMessage(): string { return $this->message; }
    public function setMessage(string $message): self { $this->message = $message; return $this; }

    public function getMessageCo(): string { return $this->messageCo; }
    public function setMessageCo(string $messageCo): self { $this->messageCo = $messageCo; return $this; }

    public function getModel(): Users { return $this->model; }
    public function setModel(Users $model): self { $this->model = $model; return $this; }

    public function getHeader(): Header { return $this->header; }
    public function setHeader(Header $header): self { $this->header = $header; return $this; }

    public function getAccueil(): AccueilView { return $this->accueil; }
    public function setAccueil(AccueilView $accueil): self { $this->accueil = $accueil; return $this; }

    public function getFooter(): Footer { return $this->footer; }
    public function setFooter(Footer $footer): self { $this->footer = $footer; return $this; }

    //METHODS
    //méthode pour l'inscription
    public function signUp(){
        if(isset($_POST['signIn'])){
            //Etape de Sécurité 1 : vérifier les champs vides
            if(!empty($_POST['nickname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordVerify']) ){

                //Etape de Sécurité 2 : Vérifier le format des données
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

                    //ETAPE de Sécurité 3 : Nettoyage des données
                    $nickname = sanitize($_POST['nickname']);
                    $email = sanitize($_POST['email']);
                    $password = sanitize($_POST['password']);
                    $passwordVerify = sanitize($_POST['passwordVerify']);

                    //Etape 4 : Vérifier la correspondance des mots de passe
                    if($password === $passwordVerify){

                        //Etape 5 : Hasher le mot de passe à enregistrer
                        $password = password_hash($password, PASSWORD_DEFAULT);

                        //Récupération de l'objet Users qui se trouve dans l'attribut model de mon objet Controller
                        $user = $this->getModel();
                        $user->setPassword($password)
                            ->setNickname($nickname)
                            ->setEmail($email);
                        $data = $user->readUserByNicknameAndEmail();

                        //Vérification des $data
                        if(empty($data)){
                            //$data vide -> signifie que nickname et email sont dispo
                            // Lance le try... catch d'inscription
                            // Try... Catch : nous permet de gérer les erreurs de communication avec la BDD et de requête envoyée à la BDD
                            $data = $user->createUser();

                            //$data = [
                            //          '$data' => [tab de reponse de la bdd],
                            //          'message' => 'message créer dans la fonction create'
                            //         ]

                            //Affichage du message de confirmation
                            $this->setMessage($data['message']);
                        }else{
                            //$data non vide -> signifie que nickname OU email indispo
                            //message d'erreur
                            $this->setMessage('Pseudo ou Email indisponible.');
                        }
                        

                    }else{
                        $this->setMessage("Vos mots de passe ne sont pas identiques");
                    }

                }else{
                    $this->setMessage("Veuillez entrer un email valide");
                }

            }else{
                $this->setMessage("Veuillez remplir tous les champs");
            }
        }
    }

    //méthode pour la connexion
    public function signIn(){
        if(isset($_POST['signUp'])){
            //Etape de Sécurité 1 : Vérifier les champs vides
            if(!empty($_POST['nicknameSignUp']) && !empty($_POST['passwordSignUp'])){
                //Etape de Sécurité 2 : Vérifier le Format -> aucun format à vérifier ici sauf utilisé une Regex
                //Etape de Sécurité 3 : Nettoyage des données
                $nickname = sanitize($_POST['nicknameSignUp']);
                $password = sanitize($_POST['passwordSignUp']);

                //Récupération de l'objet Users qui se trouve dans l'attribut model de mon objet Controller
                $user = $this->getModel();
                $user->setNickname($nickname);
                $data = $user->readUserByNickname();

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
                        $this->setMessageCo("{$_SESSION['nickname']} est connecté");

                    }else{
                        $this->setMessageCo("Problème de Login et/ou Mot de Passe");
                    }
                }else{
                    //$data vide -> l'utilisateur n'existe pas -> message d'erreur
                    $this->setMessageCo("Problème de Login et/ou Mot de Passe");
                }

                

            }else{
                $this->setMessageCo("Veuillez remplir tous les champs !");
            }

        }
    }

    //méthode pour appeler l'affichage
    public function displayAccueil(){
        //Lancement des traitements des formulaires
        $this->signUp();
        $this->signIn();

        //Lancement de l'affichage du header
        echo $this->getHeader()->setTitle($this->getTitle())->setStyle($this->getStyle())->renderHeader();

        //Lancement de l'affichage de l'accueil
        echo $this->getAccueil()->setMessage($this->getMessage())->setMessageCo($this->getMessageCo())->renderAccueil();
                
        //Lancement de l'affichage du footer
        echo $this->getFooter()->setContent("<p>Bienvenue sur l'Accueil de Ma Todo</p>")->renderFooter();
    }
}

$accueil = new AccueilController();
$accueil->displayAccueil();


?>
