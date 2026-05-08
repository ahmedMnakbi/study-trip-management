<?php
require_once __DIR__ . '/../../includes/auth.php';

require_connexion();

if (!est_post()) {
    rediriger('index.php');
}

verifier_csrf();
deconnecter_utilisateur();
session_destroy();
session_start();
message_flash('success', 'Vous etes deconnecte.');
rediriger('pages/auth/login.php');

