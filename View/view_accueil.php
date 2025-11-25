<?php
class AccueilView{
    //Attribut
    private string $message = '';
    private string $messageCo = '';

    //Constructeur
    public function __construct(){}

    //GETTER ET SETTER
    public function getMessage(): string { return $this->message; }
    public function setMessage(string $message): self { $this->message = $message; return $this; }

    public function getMessageCo(): string { return $this->messageCo; }
    public function setMessageCo(string $messageCo): self { $this->messageCo = $messageCo; return $this; }

    //METHOD
    public function renderAccueil(){
        //Exemple d'affichage dynamique selon qu'un utilisateur est connecté ou non
        //Je vérifier la $_SESSION
        //Si elle n'existe pas, alors l'utilisateur n'est pas connecté et j'affiche avec du HTML avec un echo
        if(!isset($_SESSION['role'])){
            $accueil = "
                <h2>Inscription Utilisateur</h2>
                <form action='' method='post'>
                    <label for='nickname'>Pseudo</label><input type='text' id='nickname' name='nickname'>
                    <label for='email'>Email</label><input type='text' id='email' name='email'>
                    <label for='password'>Mot de Passe</label><input type='text' id='password' name='password'>
                    <label for='passwordVerify'>Retappez le Mot de Passe</label><input type='text' id='passwordVerify' name='passwordVerify'>
                    <input type='submit' name='signIn' value=\"S'inscrire\">
                </form>
                    
                <p>".$this->getMessage()."</p>

                <h2>Connexion Utilisateur</h2>
                <form action='' method='post'>
                    <label for='nicknameSignUp'>Pseudo</label><input type='text' id='nicknameSignUp' name='nicknameSignUp'>
                    <label for='passwordSignUp'>Password</label><input type='text' id='passwordSignUp' name='passwordSignUp'>
                    <input type='submit' name='signUp' value='Se Connecter'>
                </form>
                <p>".$this->getMessageCo()."</p>";

        }else{ //Sinon, l'utilisateur est connecté, et j'affiche un autre HTML avec un echo
            $accueil =  "
                <h2>Bienvenue {$_SESSION['nickname']}</h2>
                <p>Pseudo : {$_SESSION['nickname']} </p>
                <p>Email : {$_SESSION['email']} </p>
                <p>Role : {$_SESSION['role']} </p>
            ";
        }

        return "<h1>Bienvenue sur le Projet Task</h1>".$accueil;
    }
}

?>


      