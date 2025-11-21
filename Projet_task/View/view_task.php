<h2>Ma To-do list</h2>
    <fieldset>
        <legend>Créez une tâche</legend>
        <form action="" method="POST">
        <input type="text" id="nameTask" name="nameTask">
        <label for="nameTask">Nom de la tâche</label>
        <textarea name="contentTask" id="contentTask"></textarea>
        <label for="contentTask">Descritpion de la tâche</label>
        <input type="date" id="dateTask" name="dateTask">
        <label for="dateTask">Date d'ajout de la tâche</label>
        <input type="submit" name="add" value="Ajouter tâche">
        </form>
    </fieldset>
    <?php 
    
    echo $messageTask;

    if (isset($_POST['nameTask'])) {
        echo "<h1>Dernière tâche créée :</h1>";
        echo "<p>Nom de la tâche : " . $_POST['nameTask'] . "</p>";
        echo "<p>Description de la tâche : " . $_POST['contentTask'] . "</p>";
        echo "<p>Date de création : " . $_POST['dateTask'] . "</p>";
    };
    ?>
    
