<?php
require_once __DIR__ . '/includes/auth.php';

if (role_utilisateur() === 'admin') {
    rediriger('pages/admin/dashboard.php');
}

if (role_utilisateur() === 'responsable') {
    rediriger('pages/voyages/mes_voyages.php');
}

rediriger('pages/voyages/liste_voyages.php');

