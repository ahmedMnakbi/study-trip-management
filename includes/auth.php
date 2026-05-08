<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/functions.php';

function utilisateur_connecte()
{
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function id_utilisateur()
{
    return isset($_SESSION['user']['id_user']) ? (int) $_SESSION['user']['id_user'] : 0;
}

function role_utilisateur()
{
    return isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : null;
}

function connecter_utilisateur($user)
{
    session_regenerate_id(true);
    $_SESSION['user'] = array(
        'id_user' => (int) $user['id_user'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'email' => $user['email'],
        'role' => $user['role']
    );
}

function deconnecter_utilisateur()
{
    unset($_SESSION['user']);
    session_regenerate_id(true);
}

function require_connexion()
{
    if (!utilisateur_connecte()) {
        message_flash('error', 'Veuillez vous connecter.');
        rediriger('pages/auth/login.php');
    }
}

function require_role($roles)
{
    require_connexion();

    if (!is_array($roles)) {
        $roles = array($roles);
    }

    if (!in_array(role_utilisateur(), $roles)) {
        http_response_code(403);
        echo 'Acces refuse.';
        exit;
    }
}

