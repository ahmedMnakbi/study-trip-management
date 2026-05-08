<?php

require_once __DIR__ . '/../config/database.php';

class Voyage
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connexion();
    }

    public function creer($donnees)
    {
        $sql = 'INSERT INTO voyages (titre, destination, description, date_depart, date_retour, budget, nb_places, statut, id_responsable)
                VALUES (:titre, :destination, :description, :date_depart, :date_retour, :budget, :nb_places, :statut, :id_responsable)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array(
            'titre' => $donnees['titre'],
            'destination' => $donnees['destination'],
            'description' => $donnees['description'],
            'date_depart' => $donnees['date_depart'],
            'date_retour' => $donnees['date_retour'],
            'budget' => $donnees['budget'],
            'nb_places' => $donnees['nb_places'],
            'statut' => 'en_attente',
            'id_responsable' => $donnees['id_responsable']
        ));
    }

    public function modifier($id, $id_responsable, $donnees)
    {
        $sql = 'UPDATE voyages
                SET titre = :titre, destination = :destination, description = :description,
                    date_depart = :date_depart, date_retour = :date_retour,
                    budget = :budget, nb_places = :nb_places,
                    statut = CASE WHEN statut = "refuse" THEN "en_attente" ELSE statut END
                WHERE id_voyage = :id AND id_responsable = :id_responsable';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array(
            'id' => $id,
            'id_responsable' => $id_responsable,
            'titre' => $donnees['titre'],
            'destination' => $donnees['destination'],
            'description' => $donnees['description'],
            'date_depart' => $donnees['date_depart'],
            'date_retour' => $donnees['date_retour'],
            'budget' => $donnees['budget'],
            'nb_places' => $donnees['nb_places']
        ));
    }

    public function annuler($id, $id_responsable)
    {
        $stmt = $this->pdo->prepare("UPDATE voyages SET statut = 'annule' WHERE id_voyage = :id AND id_responsable = :id_responsable");
        return $stmt->execute(array('id' => $id, 'id_responsable' => $id_responsable));
    }

    public function changerStatut($id, $statut)
    {
        $stmt = $this->pdo->prepare('UPDATE voyages SET statut = :statut WHERE id_voyage = :id');
        return $stmt->execute(array('id' => $id, 'statut' => $statut));
    }

    public function trouverParId($id)
    {
        $stmt = $this->pdo->prepare($this->selectBase() . ' WHERE v.id_voyage = :id LIMIT 1');
        $stmt->execute(array('id' => $id));
        return $stmt->fetch();
    }

    public function trouverPourResponsable($id, $id_responsable)
    {
        $stmt = $this->pdo->prepare($this->selectBase() . ' WHERE v.id_voyage = :id AND v.id_responsable = :id_responsable LIMIT 1');
        $stmt->execute(array('id' => $id, 'id_responsable' => $id_responsable));
        return $stmt->fetch();
    }

    public function listerValides($recherche)
    {
        $sql = $this->selectBase() . " WHERE v.statut = 'valide'";
        $params = array();

        if ($recherche !== '') {
            $sql .= ' AND (v.titre LIKE :recherche OR v.destination LIKE :recherche)';
            $params['recherche'] = '%' . $recherche . '%';
        }

        $sql .= ' ORDER BY v.date_depart ASC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function listerParResponsable($id_responsable)
    {
        $stmt = $this->pdo->prepare($this->selectBase() . ' WHERE v.id_responsable = :id ORDER BY v.date_creation DESC');
        $stmt->execute(array('id' => $id_responsable));
        return $stmt->fetchAll();
    }

    public function listerTous()
    {
        return $this->pdo->query($this->selectBase() . ' ORDER BY v.date_creation DESC')->fetchAll();
    }

    public function placesRestantes($id_voyage)
    {
        $voyage = $this->trouverParId($id_voyage);
        if (!$voyage) {
            return 0;
        }
        return (int) $voyage['places_restantes'];
    }

    public function placesDisponiblesInscription($id_voyage)
    {
        $sql = "SELECT v.nb_places - (
                    SELECT COUNT(*) FROM inscriptions i
                    WHERE i.id_voyage = v.id_voyage
                    AND i.statut IN ('en_attente', 'valide')
                ) AS disponibles
                FROM voyages v
                WHERE v.id_voyage = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id' => $id_voyage));
        return (int) $stmt->fetchColumn();
    }

    public function compterTous()
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM voyages')->fetchColumn();
    }

    public function compterEnAttente()
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM voyages WHERE statut = 'en_attente'")->fetchColumn();
    }

    private function selectBase()
    {
        return "SELECT v.*, u.nom AS responsable_nom, u.prenom AS responsable_prenom,
                (SELECT COUNT(*) FROM inscriptions i WHERE i.id_voyage = v.id_voyage AND i.statut = 'valide') AS nb_inscrits_valides,
                (v.nb_places - (SELECT COUNT(*) FROM inscriptions i2 WHERE i2.id_voyage = v.id_voyage AND i2.statut = 'valide')) AS places_restantes
                FROM voyages v
                INNER JOIN users u ON u.id_user = v.id_responsable";
    }
}
