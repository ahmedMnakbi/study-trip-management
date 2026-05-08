<?php

function e($valeur)
{
    return htmlspecialchars((string) $valeur, ENT_QUOTES, 'UTF-8');
}

function base_url()
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $positionPages = strpos($script, '/pages/');

    if ($positionPages !== false) {
        return rtrim(substr($script, 0, $positionPages), '/');
    }

    return rtrim(dirname($script), '/\\');
}

function url($chemin = '')
{
    $base = base_url();
    return ($base === '' ? '' : $base) . '/' . ltrim($chemin, '/');
}

function rediriger($chemin)
{
    header('Location: ' . url($chemin));
    exit;
}

function message_flash($type, $message)
{
    $_SESSION['flash'][] = array('type' => $type, 'message' => $message);
}

function afficher_flash()
{
    if (empty($_SESSION['flash'])) {
        return;
    }

    foreach ($_SESSION['flash'] as $flash) {
        echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
    }

    unset($_SESSION['flash']);
}

// Bonus simple: un jeton CSRF protege les formulaires POST sensibles.
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function champ_csrf()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verifier_csrf()
{
    $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    $sessionToken = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';

    if (!is_string($token) || !hash_equals($sessionToken, $token)) {
        message_flash('error', 'Formulaire invalide ou session expiree.');
        rediriger('index.php');
    }
}

function est_post()
{
    return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST';
}

function libelle_statut($statut)
{
    $labels = array(
        'en_attente' => 'En attente',
        'valide' => 'Valide',
        'refuse' => 'Refuse',
        'annule' => 'Annule',
        'actif' => 'Actif',
        'inactif' => 'Inactif'
    );

    return isset($labels[$statut]) ? $labels[$statut] : ucfirst($statut);
}
