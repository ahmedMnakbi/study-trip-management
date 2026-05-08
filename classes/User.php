<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connexion();
    }

    public function creer($donnees)
    {
        $sql = 'INSERT INTO users (nom, prenom, email, mot_de_passe, role, statut)
                VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :statut)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            'nom' => $donnees['nom'],
            'prenom' => $donnees['prenom'],
            'email' => $donnees['email'],
            'mot_de_passe' => password_hash($donnees['mot_de_passe'], PASSWORD_DEFAULT),
            'role' => isset($donnees['role']) ? $donnees['role'] : 'etudiant',
            'statut' => isset($donnees['statut']) ? $donnees['statut'] : 'actif'
        ));
    }

    public function trouverParEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(array('email' => $email));
        return $stmt->fetch();
    }

    public function trouverParId($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id_user = :id LIMIT 1');
        $stmt->execute(array('id' => $id));
        return $stmt->fetch();
    }

    public function listerTous()
    {
        return $this->pdo->query('SELECT id_user, nom, prenom, email, role, statut, date_creation FROM users ORDER BY date_creation DESC')->fetchAll();
    }

    public function modifierRoleStatut($id, $role, $statut)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET role = :role, statut = :statut WHERE id_user = :id');
        return $stmt->execute(array('id' => $id, 'role' => $role, 'statut' => $statut));
    }

    public function compterTous()
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function compterAdminsActifs()
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin' AND statut = 'actif'")->fetchColumn();
    }
}

