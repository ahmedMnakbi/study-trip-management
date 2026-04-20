<?php

declare(strict_types=1);

class Voyage extends Model
{
    public function validated(?string $search = null): array
    {
        $sql = $this->baseSelect() . " WHERE v.statut = 'valide'";
        $params = [];

        if ($search !== null && trim($search) !== '') {
            $sql .= ' AND (v.titre LIKE :search OR v.destination LIKE :search)';
            $params['search'] = '%' . trim($search) . '%';
        }

        $sql .= ' ORDER BY v.date_depart ASC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare($this->baseSelect() . ' WHERE v.id_voyage = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $voyage = $stmt->fetch();

        return $voyage ?: null;
    }

    public function byResponsible(int $responsableId): array
    {
        $stmt = $this->db->prepare(
            $this->baseSelect() . ' WHERE v.id_responsable = :id ORDER BY v.date_creation DESC'
        );
        $stmt->execute(['id' => $responsableId]);

        return $stmt->fetchAll();
    }

    public function pending(): array
    {
        $stmt = $this->db->query(
            $this->baseSelect() . " WHERE v.statut = 'en_attente' ORDER BY v.date_creation ASC"
        );

        return $stmt->fetchAll();
    }

    public function allForAdmin(): array
    {
        $stmt = $this->db->query($this->baseSelect() . ' ORDER BY v.date_creation DESC');

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO voyages
             (titre, destination, description, date_depart, date_retour, budget, nb_places, statut, id_responsable)
             VALUES
             (:titre, :destination, :description, :date_depart, :date_retour, :budget, :nb_places, :statut, :id_responsable)'
        );

        $stmt->execute([
            'titre' => $data['titre'],
            'destination' => $data['destination'],
            'description' => $data['description'],
            'date_depart' => $data['date_depart'],
            'date_retour' => $data['date_retour'],
            'budget' => $data['budget'],
            'nb_places' => $data['nb_places'],
            'statut' => $data['statut'] ?? 'en_attente',
            'id_responsable' => $data['id_responsable'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, int $responsableId, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE voyages
             SET titre = :titre,
                 destination = :destination,
                 description = :description,
                 date_depart = :date_depart,
                 date_retour = :date_retour,
                 budget = :budget,
                 nb_places = :nb_places,
                 statut = CASE WHEN statut = 'refuse' THEN 'en_attente' ELSE statut END
             WHERE id_voyage = :id AND id_responsable = :id_responsable"
        );

        $stmt->execute([
            'id' => $id,
            'id_responsable' => $responsableId,
            'titre' => $data['titre'],
            'destination' => $data['destination'],
            'description' => $data['description'],
            'date_depart' => $data['date_depart'],
            'date_retour' => $data['date_retour'],
            'budget' => $data['budget'],
            'nb_places' => $data['nb_places'],
        ]);

        return $stmt->rowCount() > 0;
    }

    public function updateStatus(int $id, string $status): void
    {
        $stmt = $this->db->prepare('UPDATE voyages SET statut = :statut WHERE id_voyage = :id');
        $stmt->execute([
            'id' => $id,
            'statut' => $status,
        ]);
    }

    public function updateStatusForResponsible(int $id, int $responsableId, string $status): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE voyages
             SET statut = :statut
             WHERE id_voyage = :id AND id_responsable = :id_responsable'
        );
        $stmt->execute([
            'id' => $id,
            'id_responsable' => $responsableId,
            'statut' => $status,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function countActiveInscriptions(int $voyageId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) AS total
             FROM inscriptions
             WHERE id_voyage = :id AND statut IN ('en_attente', 'valide')"
        );
        $stmt->execute(['id' => $voyageId]);

        return (int) $stmt->fetchColumn();
    }

    public function stats(): array
    {
        $stmt = $this->db->query(
            "SELECT
                COUNT(*) AS total,
                COALESCE(SUM(statut = 'en_attente'), 0) AS en_attente,
                COALESCE(SUM(statut = 'valide'), 0) AS valide,
                COALESCE(SUM(statut = 'refuse'), 0) AS refuse,
                COALESCE(SUM(statut = 'archive'), 0) AS archive
             FROM voyages"
        );

        return $stmt->fetch() ?: [
            'total' => 0,
            'en_attente' => 0,
            'valide' => 0,
            'refuse' => 0,
            'archive' => 0,
        ];
    }

    private function baseSelect(): string
    {
        return "SELECT
                    v.*,
                    u.nom AS responsable_nom,
                    u.prenom AS responsable_prenom,
                    (
                        SELECT COUNT(*)
                        FROM inscriptions i
                        WHERE i.id_voyage = v.id_voyage
                          AND i.statut IN ('en_attente', 'valide')
                    ) AS nb_inscrits,
                    (
                        v.nb_places - (
                            SELECT COUNT(*)
                            FROM inscriptions i2
                            WHERE i2.id_voyage = v.id_voyage
                              AND i2.statut IN ('en_attente', 'valide')
                        )
                    ) AS places_restantes
                FROM voyages v
                INNER JOIN users u ON u.id_user = v.id_responsable";
    }
}
