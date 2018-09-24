<?php session_start();
include "templates/header.php";
?>

<ul>
	<?php if (isset($_SESSION['id']) && $_SESSION['grade'] == 2) { ?>
		<li><a href="../install.php"><strong>Installer</strong></a> - Installer la base de données</li>
	<?php } ?>
	<?php if (isset($_SESSION['id']) && $_SESSION['grade'] > 0) { ?>
		<li><a href="create.php"><strong>Créer</strong></a> - Ajouter un employé</li>
	<?php } ?>
	<li><a href="lire.php"><strong>Lire</strong></a> - Afficher les employés</li>
	<?php if (!isset($_SESSION['id'])) { ?>
	<li><a href="connect.php"><strong>Connecter</strong></a> - Connexion</li>
<?php } else { ?>
	<li><a href="disconnect.php"><strong>Deconnecter</strong></a> - Déconnexion</li>
<?php } ?>
</ul>

<?php include "templates/footer.php"; ?>