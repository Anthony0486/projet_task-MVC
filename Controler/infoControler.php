<?php

class InfoController {

    private string $title = 'Mon Compte Utilisateur';
    private string $style='./src/style/style-info.css';
    private string $message = '';
    private Users $model;
    private Header $header;
    private Footer $footer;
    private InfoView $info;
 
    public function __construct(){
        $this->model = new Users(new PDO('mysql:host=localhost;dbname=task','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)));
        $this->header = new Header();
        $this->footer = new Footer();
        $this->info = new InfoView();
    }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }

    public function getStyle(): string { return $this->style; }
    public function setStyle(string $style): self { $this->style = $style; return $this; }

    public function getMessage(): string { return $this->message; }
    public function setMessage(string $message): self { $this->message = $message; return $this; }
    public function getModel(): Users { return $this->model; }
    public function setModel(Users $model): self { $this->model = $model; return $this; }

    public function getHeader(): Header { return $this->header; }
    public function setHeader(Header $header): self { $this->header = $header; return $this; }
    public function getFooter(): Footer { return $this->footer; }
    public function setFooter(Footer $footer): self { $this->footer = $footer; return $this; }
    public function getInfo(): InfoView {return $this->info;}
    public function setInfo(InfoView $info): self {$this->info = $info;return $this;}

    public function isConnected(){
        if(!isset($_SESSION['id'])){
            header('Location: /projet_task/accueil/');
        }
    }
    public function updateUser(): void{
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

    $this->setMessage($user->updateUser());
    }

    }
    public function displayInfo(){
        $this->isConnected();
        $this->updateUser();
        echo $this->getHeader()->setTitle($this->getTitle())->setStyle($this->getStyle())->renderHeader();
        echo $this->getInfo()->renderInfo();
        echo $this->getFooter()->setContent($this->getMessage())->renderFooter();
    }
}



?>

