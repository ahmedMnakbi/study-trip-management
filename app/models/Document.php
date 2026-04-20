<?php

declare(strict_types=1);

class Document extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO documents (id_user, id_voyage, type_document, chemin_fichier)
             VALUES (:id_user, :id_voyage, :type_document, :chemin_fichier)'
        );

        $stmt->execute([
            'id_user' => $data['id_user'],
            'id_voyage' => $data['id_voyage'],
            'type_document' => $data['type_document'],
            'chemin_fichier' => $data['chemin_fichier'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function forStudent(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, v.titre, v.destination
             FROM documents d
             LEFT JOIN voyages v ON v.id_voyage = d.id_voyage
             WHERE d.id_user = :id_user
             ORDER BY d.date_upload DESC'
        );
        $stmt->execute(['id_user' => $userId]);

        return $stmt->fetchAll();
    }

    public function forVoyage(int $voyageId): array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, u.nom, u.prenom, u.email
             FROM documents d
             INNER JOIN users u ON u.id_user = d.id_user
             WHERE d.id_voyage = :id_voyage
             ORDER BY d.date_upload DESC'
        );
        $stmt->execute(['id_voyage' => $voyageId]);

        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->db->query(
            'SELECT d.*, u.nom, u.prenom, u.email, v.titre, v.destination
             FROM documents d
             INNER JOIN users u ON u.id_user = d.id_user
             LEFT JOIN voyages v ON v.id_voyage = d.id_voyage
             ORDER BY d.date_upload DESC'
        );

        return $stmt->fetchAll();
    }

    public function findWithContext(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, v.id_responsable
             FROM documents d
             LEFT JOIN voyages v ON v.id_voyage = d.id_voyage
             WHERE d.id_document = :id
             LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $document = $stmt->fetch();

        return $document ?: null;
    }

    public function groupByVoyageForStudent(int $userId): array
    {
        $grouped = [];

        foreach ($this->forStudent($userId) as $document) {
            $grouped[(int) $document['id_voyage']][] = $document;
        }

        return $grouped;
    }
}
