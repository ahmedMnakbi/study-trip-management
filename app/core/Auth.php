<?php

declare(strict_types=1);

class Auth
{
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return isset($_SESSION['user']['id_user']) ? (int) $_SESSION['user']['id_user'] : null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function role(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id_user' => (int) $user['id_user'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            flash('error', 'Veuillez vous connecter pour continuer.');
            redirect('login');
        }
    }

    public static function requireRole(array|string $roles): void
    {
        self::requireLogin();

        $allowed = is_array($roles) ? $roles : [$roles];

        if (!in_array(self::role(), $allowed, true)) {
            http_response_code(403);
            require VIEW_PATH . DIRECTORY_SEPARATOR . 'errors' . DIRECTORY_SEPARATOR . '403.php';
            exit;
        }
    }
}
