<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $route = '', array $params = []): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/public/index.php');
    $query = array_merge(['route' => trim($route, '/')], $params);

    if ($query['route'] === '') {
        $query['route'] = 'home';
    }

    return $script . '?' . http_build_query($query);
}

function asset(string $path): string
{
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    if (str_ends_with($scriptDir, '/public')) {
        $scriptDir = substr($scriptDir, 0, -7);
    }

    return ($scriptDir === '' ? '' : $scriptDir) . '/' . ltrim($path, '/');
}

function redirect(string $route, array $params = []): void
{
    header('Location: ' . url($route, $params));
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = [
        'type' => $type,
        'message' => $message,
    ];
}

function get_flash_messages(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);

    return $messages;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';

    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        flash('error', 'Session expiree ou formulaire invalide.');
        redirect('home');
    }
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function status_label(string $status): string
{
    return [
        'en_attente' => 'En attente',
        'valide' => 'Valide',
        'refuse' => 'Refuse',
        'archive' => 'Archive',
        'annule' => 'Annule',
        'actif' => 'Actif',
        'inactif' => 'Inactif',
    ][$status] ?? ucfirst(str_replace('_', ' ', $status));
}

function excerpt(string $text, int $limit = 140): string
{
    $clean = trim(preg_replace('/\s+/', ' ', $text) ?? '');

    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($clean, 0, $limit, '...', 'UTF-8');
    }

    return strlen($clean) > $limit ? substr($clean, 0, $limit - 3) . '...' : $clean;
}

function current_route(): string
{
    return trim((string) ($_GET['route'] ?? 'home'), '/');
}
