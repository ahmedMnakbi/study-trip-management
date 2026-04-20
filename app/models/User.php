<?php

declare(strict_types=1);

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id_user = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (nom, prenom, email, mot_de_passe, role)
             VALUES (:nom, :prenom, :email, :mot_de_passe, :role)'
        );

        $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'mot_de_passe' => password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'etudiant',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function all(): array
    {
        $stmt = $this->db->query(
            'SELECT id_user, nom, prenom, email, role, statut, date_creation
             FROM users
             ORDER BY date_creation DESC'
        );

        return $stmt->fetchAll();
    }

    public function updateRoleAndStatus(int $id, string $role, string $statut): void
    {
        $stmt = $this->db->prepare(
            'UPDATE users SET role = :role, statut = :statut WHERE id_user = :id'
        );
        $stmt->execute([
            'id' => $id,
            'role' => $role,
            'statut' => $statut,
        ]);
    }

    public function countByRole(): array
    {
        $stmt = $this->db->query(
            'SELECT role, COUNT(*) AS total
             FROM users
             GROUP BY role
             ORDER BY role'
        );

        return $stmt->fetchAll();
    }
}
