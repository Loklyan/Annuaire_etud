<?php

/**
 * Utilisez un formulaire HTML pour créer une nouvelle entrée 
 * dans la table des utilisateurs.
 *
 */
session_start();

if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "prenom"    => $_POST['prenom'],
            "nom"       => $_POST['nom'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "ville"     => $_POST['ville'],
            "mdp"       => $_POST['pass'],
            "grade"     => $_POST['grade']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "employes",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['prenom']; ?> a été ajouté avec succès.</blockquote>
<?php } ?>

<h2>Ajouter un employé</h2>

<form method="post">
    <label for="prenom">Prénom</label>
    <input type="text" name="prenom" id="prenom" required>
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" required>
    <label for="email">Adresse mail</label>
    <input type="email" name="email" id="email">
    <label for="age">Age</label>
    <input type="number" name="age" id="age">
    <label for="ville">ville de résidence</label>
    <input type="text" name="ville" id="ville">
    <label for="pass">Mot de passe</label>
    <input type="password" name="pass" id="pass">
    <?php if(isset($_SESSION['id']) && $_SESSION['grade'] == 2){ ?>
    <label for="grade">Grade</label>
    <select name="grade" id="grade">
        <option value='0'>Utilisateur</option>
        <option value='1'>Administrateur</option>
        <option value='2'>Super Adminstrateur</option>
    </select>
    <?php } ?>
    <br><br>
    <input type="submit" name="submit" value="Ajouter">
    <br><br>
</form>

<a href="index.php">Retour</a>

<?php require "templates/footer.php"; ?>
