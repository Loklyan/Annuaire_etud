<?php
/**
 * Fonction pour interroger les informations en fonction du
 * paramètre: ville
 *
 */
session_start();

    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

if (isset($_POST['submit'])) {
    try  {

        $ville = $_POST['ville'];

        if ($_POST['ville'] == "") {
            $sql = "SELECT * 
                FROM employes";
        }else{
            $sql = "SELECT * 
                FROM employes WHERE ville = :ville";
        }

        $statement = $connection->prepare($sql);
        $statement->bindParam(':ville', $ville, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_POST['supp'])) {
    foreach ($_POST['remove'] as $key) {
        $delsql = "DELETE FROM employes WHERE id like (:id)";
        $reqdelete = $connection->prepare($delsql);
        $reqdelete -> bindParam(':id', $key, PDO::PARAM_STR);
        $reqdelete -> execute();
    }
}
?>
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Liste des employés</h2>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Adresse mail</th>
                    <th>Age</th>
                    <th>ville</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <form method="post" id="form1">
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["id"]); ?></td>
                <td><?php echo escape($row["prenom"]); ?></td>
                <td><?php echo escape($row["nom"]); ?></td>
                <td><?php echo escape($row["email"]); ?></td>
                <td><?php echo escape($row["age"]); ?></td>
                <td><?php echo escape($row["ville"]); ?></td>
                <td><?php echo escape($row["date"]); ?> </td>
                <?php if (isset($_SESSION['id']) && $_SESSION['grade'] > 0) { ?>
                    <td><a href="modif.php"><i class="fas fa-pen"></i></a></td>
                <?php } ?>
                <?php if (isset($_SESSION['id']) && $_SESSION['grade'] > 0) { ?>
                    <td><input type="checkbox" name="remove[]" value="<?php echo escape($row['id']); ?>"></td>
                <?php } ?>
            </tr>
        <?php } ?>
        <?php if (isset($_SESSION['id']) && $_SESSION['grade'] > 0) { ?> 
        <tr>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <td>
                <input type="submit" name="supp" value="supprimmer">
            </td>
        </tr>
        <?php } ?>
        </form>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>Aucun résultat trouvé pour <?php echo escape($_POST['ville']); ?>.</blockquote>
    <?php }
} ?> 

<h2>Liste des employés</h2>

<form method="post">
    <label for="ville">ville</label>
    <input type="text" id="ville" name="ville">
    <input type="submit" name="submit" value="Voir les résultats">
</form>

<a href="index.php">Retour</a>

<?php require "templates/footer.php"; ?>
