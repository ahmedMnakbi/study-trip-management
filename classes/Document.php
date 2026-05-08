<?php

require_once __DIR__ . '/../config/database.php';

class Document
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connexion();
    }

    public function creer($donnees)
    {
        $sql = 'INSERT INTO documents (id_user, id_voyage, type_document, nom_original, chemin_fichier, statut)
                VALUES (:id_user, :id_voyage, :type_document, :nom_original, :chemin_fichier, :statut)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array(
            'id_user' => $donnees['id_user'],
            'id_voyage' => $donnees['id_voyage'],
            'type_document' => $donnees['type_document'],
            'nom_original' => $donnees['nom_original'],
            'chemin_fichier' => $donnees['chemin_fichier'],
            'statut' => 'en_attente'
        ));
    }

    public function listerParEtudiant($id_user)
    {
        $sql = 'SELECT d.*, v.titre, v.destination
                FROM documents d
                LEFT JOIN voyages v ON v.id_voyage = d.id_voyage
                WHERE d.id_user = :id_user
                ORDER BY d.date_upload DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id_user' => $id_user));
        return $stmt->fetchAll();
    }

    public function listerPourResponsable($id_responsable)
    {
        $sql = 'SELECT d.*, u.nom, u.prenom, u.email, v.titre, v.destination
                FROM documents d
                INNER JOIN users u ON u.id_user = d.id_user
                INNER JOIN voyages v ON v.id_voyage = d.id_voyage
                WHERE v.id_responsable = :id_responsable
                ORDER BY d.date_upload DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id_responsable' => $id_responsable));
        return $stmt->fetchAll();
    }

    public function listerTous()
    {
        $sql = 'SELECT d.*, u.nom, u.prenom, u.email, v.titre, v.destination
                FROM documents d
                INNER JOIN users u ON u.id_user = d.id_user
                LEFT JOIN voyages v ON v.id_voyage = d.id_voyage
                ORDER BY d.date_upload DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function trouverAvecAcces($id_document, $user_session)
    {
        $sql = 'SELECT d.*, v.id_responsable
                FROM documents d
                LEFT JOIN voyages v ON v.id_voyage = d.id_voyage
                WHERE d.id_document = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id' => $id_document));
        $document = $stmt->fetch();

        if (!$document || !$user_session) {
            return false;
        }

        if ($user_session['role'] === 'admin') {
            return $document;
        }

        if ($user_session['role'] === 'responsable' && (int) $document['id_responsable'] === (int) $user_session['id_user']) {
            return $document;
        }

        if ($user_session['role'] === 'etudiant' && (int) $document['id_user'] === (int) $user_session['id_user']) {
            return $document;
        }

        return false;
    }
}

