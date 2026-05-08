<?php

require_once __DIR__ . '/../config/database.php';

class Inscription
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connexion();
    }

    public function existe($id_user, $id_voyage)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM inscriptions WHERE id_user = :id_user AND id_voyage = :id_voyage');
        $stmt->execute(array('id_user' => $id_user, 'id_voyage' => $id_voyage));
        return (int) $stmt->fetchColumn() > 0;
    }

    public function creer($id_user, $id_voyage)
    {
        $stmt = $this->pdo->prepare("INSERT INTO inscriptions (id_user, id_voyage, statut) VALUES (:id_user, :id_voyage, 'en_attente')");
        return $stmt->execute(array('id_user' => $id_user, 'id_voyage' => $id_voyage));
    }

    public function listerParEtudiant($id_user)
    {
        $sql = 'SELECT i.*, v.titre, v.destination, v.date_depart, v.date_retour
                FROM inscriptions i
                INNER JOIN voyages v ON v.id_voyage = i.id_voyage
                WHERE i.id_user = :id_user
                ORDER BY i.date_inscription DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id_user' => $id_user));
        return $stmt->fetchAll();
    }

    public function listerParVoyageResponsable($id_voyage, $id_responsable)
    {
        $sql = 'SELECT i.*, u.nom, u.prenom, u.email
                FROM inscriptions i
                INNER JOIN users u ON u.id_user = i.id_user
                INNER JOIN voyages v ON v.id_voyage = i.id_voyage
                WHERE i.id_voyage = :id_voyage AND v.id_responsable = :id_responsable
                ORDER BY i.date_inscription DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id_voyage' => $id_voyage, 'id_responsable' => $id_responsable));
        return $stmt->fetchAll();
    }

    public function changerStatut($id_inscription, $id_responsable, $statut)
    {
        $sql = 'UPDATE inscriptions i
                INNER JOIN voyages v ON v.id_voyage = i.id_voyage
                SET i.statut = :statut
                WHERE i.id_inscription = :id_inscription AND v.id_responsable = :id_responsable';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array(
            'id_inscription' => $id_inscription,
            'id_responsable' => $id_responsable,
            'statut' => $statut
        ));
    }

    public function trouverAvecVoyage($id_inscription, $id_responsable)
    {
        $sql = 'SELECT i.*, v.id_responsable, v.nb_places,
                (SELECT COUNT(*) FROM inscriptions x WHERE x.id_voyage = i.id_voyage AND x.statut = "valide") AS nb_valides
                FROM inscriptions i
                INNER JOIN voyages v ON v.id_voyage = i.id_voyage
                WHERE i.id_inscription = :id_inscription AND v.id_responsable = :id_responsable
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id_inscription' => $id_inscription, 'id_responsable' => $id_responsable));
        return $stmt->fetch();
    }

    public function compterTous()
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM inscriptions')->fetchColumn();
    }

    public function compterEnAttente()
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM inscriptions WHERE statut = 'en_attente'")->fetchColumn();
    }
}

