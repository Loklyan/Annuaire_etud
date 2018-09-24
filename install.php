<?php

/**
 * Ouvrir une connexion via PDO pour créer un
 * nouvelle base de données avec une table structurée.
 *
 */

require "config.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    $sql = file_get_contents("data/init.sql");
    $connection->exec($sql);
    
    echo "La base de données ont été créés avec succès.";
    echo "<br><br> <a href='index.php'>Retour</a>";

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
