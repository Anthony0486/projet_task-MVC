<h1>Voici Vos Infos</h1>
        <p>Pseudo : <?php echo $_SESSION['nickname'] ?> </p>
        <p>Email : <?php echo $_SESSION['email'] ?> </p>
        <p>Role : <?php echo $_SESSION['role'] ?> </p>

        <h2>Mise à Jour Utilisateur</h2>
        <form action="" method="post">
            <label for="firstname">Prenom :</label><input id="firstname" type="text" name="firstname">
            <label for="lastname">Nom :</label><input id="lastname" type="text" name="lastname">
            <input type="submit" name="update" value="Mettre à Jour">
        </form>