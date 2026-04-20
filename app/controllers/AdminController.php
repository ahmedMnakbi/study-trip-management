<?php

declare(strict_types=1);

class AdminController extends Controller
{
    public function dashboard(): void
    {
        Auth::requireRole('admin');

        $voyageModel = new Voyage();
        $inscriptionModel = new Inscription();
        $userModel = new User();

        $this->view('admin/dashboard', [
            'title' => 'Tableau de bord',
            'voyageStats' => $voyageModel->stats(),
            'inscriptionStats' => $inscriptionModel->statsByVoyage(),
            'userStats' => $userModel->countByRole(),
        ]);
    }

    public function users(): void
    {
        Auth::requireRole('admin');

        $this->view('admin/users', [
            'title' => 'Utilisateurs',
            'users' => (new User())->all(),
            'old' => [],
            'errors' => [],
        ]);
    }

    public function storeUser(): void
    {
        Auth::requireRole('admin');
        verify_csrf();

        $old = [
            'nom' => trim((string) ($_POST['nom'] ?? '')),
            'prenom' => trim((string) ($_POST['prenom'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'role' => (string) ($_POST['role'] ?? 'etudiant'),
        ];

        $errors = $this->validateRequired($_POST, [
            'nom' => 'Nom',
            'prenom' => 'Prenom',
            'email' => 'Email',
            'mot_de_passe' => 'Mot de passe',
        ]);

        if ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide.';
        }

        if (!in_array($old['role'], ['etudiant', 'responsable', 'admin', 'financier'], true)) {
            $errors['role'] = 'Role invalide.';
        }

        if (strlen((string) ($_POST['mot_de_passe'] ?? '')) < 6) {
            $errors['mot_de_passe'] = 'Le mot de passe doit contenir au moins 6 caracteres.';
        }

        $userModel = new User();
        if ($old['email'] !== '' && $userModel->findByEmail($old['email'])) {
            $errors['email'] = 'Cet email est deja utilise.';
        }

        if ($errors !== []) {
            $this->view('admin/users', [
                'title' => 'Utilisateurs',
                'users' => $userModel->all(),
                'old' => $old,
                'errors' => $errors,
            ]);
            return;
        }

        $userModel->create([
            'nom' => $old['nom'],
            'prenom' => $old['prenom'],
            'email' => $old['email'],
            'mot_de_passe' => (string) $_POST['mot_de_passe'],
            'role' => $old['role'],
        ]);

        flash('success', 'Utilisateur cree.');
        redirect('admin/users');
    }

    public function updateUser(): void
    {
        Auth::requireRole('admin');
        verify_csrf();

        $id = (int) ($_POST['id_user'] ?? 0);
        $role = (string) ($_POST['role'] ?? '');
        $statut = (string) ($_POST['statut'] ?? '');

        if (!in_array($role, ['etudiant', 'responsable', 'admin', 'financier'], true)
            || !in_array($statut, ['actif', 'inactif'], true)) {
            flash('error', 'Donnees utilisateur invalides.');
            redirect('admin/users');
        }

        if ($id === Auth::id() && $statut === 'inactif') {
            flash('error', 'Vous ne pouvez pas desactiver votre propre compte.');
            redirect('admin/users');
        }

        (new User())->updateRoleAndStatus($id, $role, $statut);
        flash('success', 'Utilisateur mis a jour.');
        redirect('admin/users');
    }

    public function voyages(): void
    {
        Auth::requireRole('admin');

        $this->view('admin/voyages', [
            'title' => 'Gestion des voyages',
            'voyages' => (new Voyage())->allForAdmin(),
        ]);
    }

    public function validateVoyage(): void
    {
        $this->setVoyageStatus('valide', 'Voyage valide.');
    }

    public function refuseVoyage(): void
    {
        $this->setVoyageStatus('refuse', 'Voyage refuse.');
    }

    public function archiveVoyage(): void
    {
        $this->setVoyageStatus('archive', 'Voyage archive.');
    }

    private function setVoyageStatus(string $status, string $message): void
    {
        Auth::requireRole('admin');
        verify_csrf();

        $id = (int) ($_POST['id_voyage'] ?? 0);
        (new Voyage())->updateStatus($id, $status);
        flash('success', $message);
        redirect('admin/voyages');
    }
}
