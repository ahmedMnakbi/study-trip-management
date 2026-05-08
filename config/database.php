<?php

// Connexion PDO reutilisee par les classes du projet.
function connexion()
{
    $host = '127.0.0.1';
    $dbname = 'gestion_voyages_etudes';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $password
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur de connexion a la base de donnees.');
    }
}

