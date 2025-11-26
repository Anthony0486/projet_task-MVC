<?php
class InfoView {
    private string $message ='';

    public function __construct(){}

    public function getMessage(): string { return $this->message; }
    public function setMessage(string $message): self {$this->message = $message; return $this;}

    public function renderInfo(): string{
        if(isset($_SESSION['role'])){
            return "<h1>Voici Vos Infos</h1>
            <p>Pseudo : {$_SESSION['nickname']}</p>
            <p>Email : {$_SESSION['email']}</p>
            <p>Role : {$_SESSION['role']}</p>

            <h2>Mise à Jour Utilisateur</h2>
            <form action='' method='post'>
            <label for='firstname'>Prenom :</label><input id='firstname' type='text' name='firstname'>
            <label for='lastname'>Nom :</label><input id='lastname' type='text' name='lastname'>
            <input type='submit' name='update' value='Mettre à Jour'>
            </form>";
        }
    }
}
?>




