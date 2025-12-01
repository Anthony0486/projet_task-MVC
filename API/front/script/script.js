
async function readUsers(){
    // Création de l'entête de la requête
    const HEADER = {
        method : "GET", //Méthode HTTP utilisé
        mode: "cors", //Mode d'autorisation
    };

    const id = 3;

    // Envoie de la requête HTTP
    fetch('http://localhost/projet_php/API/back/utilisateurs.php?id='+id,HEADER)
        .then((response)=>{
            return response.json(); //Decodage de la réponse JSON

        }).then((result)=>{
            console.log(result); //Exploitation de la réponse

        }).catch((error)=>{
            console.error(error);
        });
}

async function createUsers(){
    // Création de l'entête de la requête
    const HEADER = {
        method : "POST", //Méthode HTTP utilisé
        mode: "cors", //Mode d'autorisation
        body : JSON.stringify({
            nom : 'DEPRIESTER',
            prenom : 'Yoann',
            pseudo : 'Yoyo',
            password : '12345',
            dob : "1984-01-01",
            email : "yoyo@gmail.ru"
        })
    };

    // Envoie de la requête HTTP
    fetch('http://localhost/projet_task/API/back/inscription.php',HEADER)
        .then((response)=>{
            return response.json(); //Decodage de la réponse JSON

        }).then((result)=>{
            console.log(result); //Exploitation de la réponse

        }).catch((error)=>{
            console.error(error);
        });
}

createUsers();

async function updateUsers(){
    const HEADER = {
        method: "PUT",
        mode: "cors",
        body: JSON.stringify({
        nom: "Deloin",
        prenom: "Alain"    
})
    };
        fetch('http://localhost/projet_task/API/back/modifier-informations.php',HEADER)
        .then((response)=>{
            return response.json(); //Decodage de la réponse JSON

        }).then((result)=>{
            console.log(result); //Exploitation de la réponse

        }).catch((error)=>{
            console.error(error);
        });
}

updateUsers();

async function deleteUsers(){
    const HEADER = {
        method: "DELETE",
        mode: "cors",
        body: JSON.stringify({
        password: "123"
        })
    }
           fetch('http://localhost/projet_task/API/back/supprimer.php',HEADER)
        .then((response)=>{
            return response.json(); //Decodage de la réponse JSON

        }).then((result)=>{
            console.log(result); //Exploitation de la réponse

        }).catch((error)=>{
            console.error(error);
        });
}
deleteUsers();