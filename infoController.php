<?php
//Démarer la Session
session_start();

//IMPORT DE RESSOURCE
include './Model/UsersModel.php';
include './utils/functions.php';
include './View/header.php';
include './View/view_compte.php';
include './View/footer.php';


class infoController {

    private string $title = 'Mon Compte Utilisateur';
    private string $style='./src/style/style-accueil.css';
    private string $message = '';
    private string $messageCo = '';
    private Users $model;
    private Header $header;
    private AccueilView $accueil;
    private Footer $footer;
    private InfoView $info;

    
    public function __construct(){
        $this->model = new Users(new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)));
        $this->header = new Header();
        $this->accueil = new AccueilView();
        $this->footer = new Footer();
        $this->info = new InfoView();
    }

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
    public function getInfo(): InfoView {return $this->info;}
    public function setInfo(InfoView $info): self {$this->info = $info;return $this;}


    public function updateUser(): string{
    if(isset($_POST['update'])){
        $firstname = '';
        $lastname = '';

    if(!empty($_POST['firstname'])){
        $firstname = sanitize($_POST['firstname']);
    }
    if(!empty($_POST['lastname'])){
        $lastname = sanitize($_POST['lastname']);
    }
    $user = $this->getModel();

    $user->setFirstname($firstname)->setLastname($lastname)->setIdUser($_SESSION['id']);

    $message = $user->updateUser();
    }return $message;

    }

    public function displayInfo(){
        echo $this->getHeader()->setTitle($this->getTitle())->setStyle($this->getStyle())->renderHeader();
        echo $this->getFooter()->setContent("<p>Voici Vos Infos</p>")->renderFooter();
    }
}

$header = new Header();
echo $header->renderHeader();


$info = new InfoView();
echo $info->renderInfo();


$footer = new Footer();
echo $footer->renderFooter();

?>

