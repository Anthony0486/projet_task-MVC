<?php
class Users {
    //ATTRIBUTS
    private ?int $id_user;
    private ?string $firstname;
    private ?string $lastname;
    private ?string $nickname;
    private ?string $email;
    private ?string $password;
    private ?int $id_role;
    private ?PDO $bdd;

    //CONSTRUCTEUR
    public function __construct(?PDO $bdd){
        $this->bdd = $bdd;
    }

    //GETTER ET SETTER
    public function getBDD():?PDO{
        return $this->bdd;
    }

    public function setBDD(?PDO $newBdd):Users{
        $this->bdd = $newBdd;
        return $this;
    }

    public function getIdUser(): ?int { return $this->id_user; }
    public function setIdUser(?int $id_user): self { $this->id_user = $id_user; return $this; }

    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(?string $firstname): self { $this->firstname = $firstname; return $this; }

    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(?string $lastname): self { $this->lastname = $lastname; return $this; }

    public function getNickname(): ?string { return $this->nickname; }
    public function setNickname(?string $nickname): self { $this->nickname = $nickname; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): self { $this->email = $email; return $this; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): self { $this->password = $password; return $this; }

    public function getIdRole(): ?int { return $this->id_role; }
    public function setIdRole(?int $id_role): self { $this->id_role = $id_role; return $this; }

    //METHOD
    //Mes méthodes n'ont plus besoin de paramètre. En effet, elles vont chercher les données nécessaires directement au sein de l'objet avec les Getter
    public function readUserByNickname():array{
        try{
                //Préparer la requête à envoyer
                // ici $this->getBDD() me permet de récupérer l'objet de connexion PDO conserver dans l'objet user
                $req = $this->getBDD()->prepare('SELECT u.id_user, u.nickname_user, u.email_user, u.firstname_user, u.lastname_user, u.password_user, r.id_role, r.`role` FROM users u INNER JOIN `role` r ON u.id_role = r.id_role WHERE u.nickname_user = ? LIMIT 1');

                //Je récupère le pseudo de l'utilisateur avec $this->getNickname()
                $nickname = $this->getNickname();

                //Binding de Paramètre
                $req->bindParam(1,$nickname,PDO::PARAM_STR);

                //Exécuter la requête
                $req->execute();

                //Récupérer la réponse de la BDD
                $data = $req->fetch();

                return $data;
            }catch(EXCEPTION $error){
                die($error->getMessage());
            }
    }
    
    public function readUserByNicknameAndEmail():array{
        try{
                        //Prepare
                        $req = $this->getBDD()->prepare('SELECT u.id_user, u.nickname_user, u.email_user, u.firstname_user, u.lastname_user, u.password_user, r.id_role, r.`role` FROM users u INNER JOIN `role` r ON u.id_role = r.id_role WHERE u.nickname_user = ? OR u.email_user = ?');

                        $nickname = $this->getNickname();
                        $email = $this->getEmail();
                        //BindParam
                        $req->bindParam(1,$nickname,PDO::PARAM_STR);
                        $req->bindParam(2,$email,PDO::PARAM_STR);

                        //Execute
                        $req->execute();

                        //$data = FetchAll
                        $data = $req->fetchAll();

                        //[TEST] : Ici j'affiche la réponse de la BDD pour TESTER si ma requête fonctionne comme voulu
                        echo "Print_r(\$data) pour savoir ce qu'il y a dedans </br>";
                        print_r($data);

                        return $data;

                    }catch(EXCEPTION $error){
                        die($error-getMessage());
                    }
    }

    public function createUser():array{
        try{
                            //ETAPE 6.2 : Vérifier si le Pseudo et l'Email sont disponible. Former la requête à envoyer
                            $req = $this->getBDD()->prepare("INSERT INTO users (nickname_user, email_user, password_user, id_role) VALUES (?,?,?, 2)");

                            $nickname = $this->getNickname();
                            $email = $this->getEmail();
                            $password = $this->getPassword();

                            //ETAPE 6.3 : Binding de Paramètre -> relier chaque ? de la requête à une valeur
                            //1er paramètre : position du ? dans la requête
                            //2nd paramètre : valeur à insérer dans la requête
                            //3eme paramètre : format du paramètre (classiquement : STRING ou INT)
                            $req->bindParam(1,$nickname,PDO::PARAM_STR);
                            $req->bindParam(2,$email,PDO::PARAM_STR);
                            $req->bindParam(3,$password,PDO::PARAM_STR);

                            //Etape 6.3 : Envoyer la requête
                            $req->execute();

                            //Etape 6.4 : Récupérer la réponse
                            $data = $req->fetchAll();

                            //Etape 6.5 : Message de confirmation
                            $message = "$nickname a été enregistré avec succès !";

                            return ['data' => $data, 'message' => $message];

                        }catch(EXCEPTION $error){
                            die($error->getMessage());
                        }
    }

    public function updateUser():string{
        //Try Catch pour requête de Mise à jour
        try{
            //Requête préparée
            $req = $this->getBDD()->prepare('UPDATE users SET firstname_user = ?, lastname_user = ? WHERE id_user = ?');

            //Je récupère depuis l'objet les données à mettre à jour 
            $firstname = $this->getFirstname();
            $lastname = $this->getLastname();
            $id = $this->getIdUser();

            //Binding de Paramètre
            $req->bindParam(1,$firstname,PDO::PARAM_STR);
            $req->bindParam(2,$lastname,PDO::PARAM_STR);
            $req->bindParam(3,$id,PDO::PARAM_INT);

            //Execution de la requête
            $req->execute();

            //Retourner un message de confirmation
            return "Mise à jour effectué avec succès";

        }catch(EXCEPTION $error){
            die($error->getMessage());
        }
    }
    
}


?>