<?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=alex-zicaro_moduleconnexion;charset=utf8', 'alex-zicaro', 'Lilinette83', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } 
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
        
?>