<h1>Mes ToDoes</h1>
<section>
    <h2>Ajouter une ToDo</h2>
    <form action="" method="post">
        <label for="nameTask">Titre : </label><input id="nameTask" type="text" name="nameTask">
        <label for="contentTask">Contenu : </label><input id="contentTask" type="text" name="contentTask">
        <label for="dateTask">Date : </label><input id="dateTask" type="date" name="dateTask">
        <fieldset>
            <legend>Les Categories</legend>
            <?php echo $checkboxCategories ?>
        </fieldset>
        <input type="submit" name="addTask" value="Ajouter la Tâche">
    </form>
    <p><?php echo $message ?></p>
</section>
<section>
    <h2>Liste de Mes ToDoes</h2>
    <?php echo $todoList ?>
</section>