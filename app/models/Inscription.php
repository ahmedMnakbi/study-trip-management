<?php

declare(strict_types=1);

class Inscription extends Model
{
    public function exists(int $userId, int $voyageId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*)
             FROM inscriptions
             WHERE id_user = :id_user AND id_voyage = :id_voyage'
        );
        $stmt->execute([
            'id_user' => $userId,
            'id_voyage' => $voyageId,
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(int $userId, int $voyageId, string $status = 'en_attente'): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO inscriptions (id_user, id_voyage, statut)
             VALUES (:id_user, :id_voyage, :statut)'
        );
        $stmt->execute([
            'id_user' => $userId,
            'id_voyage' => $voyageId,
            'statut' => $status,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function forStudent(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT i.*, v.titre, v.destination, v.date_depart, v.date_retour
             FROM inscriptions i
             INNER JOIN voyages v ON v.id_voyage = i.id_voyage
             WHERE i.id_user = :id_user
             ORDER BY i.date_inscription DESC'
        );
        $stmt->execute(['id_user' => $userId]);

        return $stmt->fetchAll();
    }

    public function forVoyage(int $voyageId): array
    {
        $stmt = $this->db->prepare(
            'SELECT i.*, u.nom, u.prenom, u.email
             FROM inscriptions i
             INNER JOIN users u ON u.id_user = i.id_user
             WHERE i.id_voyage = :id_voyage
             ORDER BY i.date_inscription DESC'
        );
        $stmt->execute(['id_voyage' => $voyageId]);

        return $stmt->fetchAll();
    }

    public function updateStatusForResponsible(
        int $inscriptionId,
        int $responsableId,
        string $status
    ): bool {
        $stmt = $this->db->prepare(
            'UPDATE inscriptions i
             INNER JOIN voyages v ON v.id_voyage = i.id_voyage
             SET i.statut = :statut
             WHERE i.id_inscription = :id_inscription
               AND v.id_responsable = :id_responsable'
        );
        $stmt->execute([
            'id_inscription' => $inscriptionId,
            'id_responsable' => $responsableId,
            'statut' => $status,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function statsByVoyage(): array
    {
        $stmt = $this->db->query(
            'SELECT v.titre, v.destination, COUNT(i.id_inscription) AS total
             FROM voyages v
             LEFT JOIN inscriptions i ON i.id_voyage = v.id_voyage
             GROUP BY v.id_voyage, v.titre, v.destination
             ORDER BY total DESC, v.titre ASC'
        );

        return $stmt->fetchAll();
    }
}
