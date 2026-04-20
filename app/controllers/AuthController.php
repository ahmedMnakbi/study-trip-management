<?php

declare(strict_types=1);

class AuthController extends Controller
{
    public function login(): void
    {
        $this->view('auth/login', [
            'title' => 'Connexion',
            'old' => ['email' => ''],
            'errors' => [],
        ]);
    }

    public function authenticate(): void
    {
        verify_csrf();

        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['mot_de_passe'] ?? '');
        $errors = $this->validateRequired($_POST, [
            'email' => 'Email',
            'mot_de_passe' => 'Mot de passe',
        ]);

        if ($errors !== []) {
            $this->view('auth/login', [
                'title' => 'Connexion',
                'old' => ['email' => $email],
                'errors' => $errors,
            ]);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            $this->view('auth/login', [
                'title' => 'Connexion',
                'old' => ['email' => $email],
                'errors' => ['email' => 'Identifiants invalides.'],
            ]);
            return;
        }

        if ($user['statut'] !== 'actif') {
            $this->view('auth/login', [
                'title' => 'Connexion',
                'old' => ['email' => $email],
                'errors' => ['email' => 'Ce compte est desactive.'],
            ]);
            return;
        }

        Auth::login($user);
        flash('success', 'Bienvenue ' . $user['prenom'] . ' !');
        redirect('home');
    }

    public function register(): void
    {
        $this->view('auth/register', [
            'title' => 'Creation de compte',
            'old' => [],
            'errors' => [],
        ]);
    }

    public function storeRegister(): void
    {
        verify_csrf();

        $old = [
            'nom' => trim((string) ($_POST['nom'] ?? '')),
            'prenom' => trim((string) ($_POST['prenom'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
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

        if (strlen((string) ($_POST['mot_de_passe'] ?? '')) < 6) {
            $errors['mot_de_passe'] = 'Le mot de passe doit contenir au moins 6 caracteres.';
        }

        $userModel = new User();
        if ($old['email'] !== '' && $userModel->findByEmail($old['email'])) {
            $errors['email'] = 'Cet email est deja utilise.';
        }

        if ($errors !== []) {
            $this->view('auth/register', [
                'title' => 'Creation de compte',
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
            'role' => 'etudiant',
        ]);

        flash('success', 'Compte cree. Vous pouvez vous connecter.');
        redirect('login');
    }

    public function logout(): void
    {
        Auth::logout();
        flash('success', 'Vous etes deconnecte.');
        redirect('login');
    }
}
