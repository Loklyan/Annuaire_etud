<?php
session_start();

if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $sqluser = "SELECT * FROM employes WHERE email = :mail and mdp = :pass";
        $requser=$connection->prepare($sqluser);
        $requser->execute(array('mail' => $_POST['mail'], 'pass'=>$_POST['pass']));
        $userexist = $requser->rowCount();

        if ($userexist == 1) {
        	$userinfo = $requser->fetch();
        	$_SESSION['id'] = $userinfo['id'];
        	$_SESSION['prenom'] = $userinfo['prenom'];
        	$_SESSION['email'] = $userinfo['email'];
        	$_SESSION['grade'] = $userinfo['grade'];
        	header("Location: ../index.php");
        }
       
    } catch(PDOException $error) {
        echo $sqluser . "<br>" . $error->getMessage();
    }
}

    require "templates/header.php";

	if (isset($_POST['submit']) && $sqluser) { ?>
    <blockquote>Connecter.</blockquote>
<?php } ?>

<h2>Connection</h2>

<form method="post">
	<label for="mail">Adresse Mail</label>
	<input type="mail" name="mail" required>
	<label for="pas">Mot de passe</label>
	<input type="password" name="pass" required>
	<input type="submit" name="submit">
</form>