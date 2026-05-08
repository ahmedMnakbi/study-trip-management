<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Inscription.php';

require_role('responsable');

if (!est_post()) {
    rediriger('pages/voyages/mes_voyages.php');
}

verifier_csrf();
$id_inscription = isset($_POST['id_inscription']) ? (int) $_POST['id_inscription'] : 0;
$id_voyage = isset($_POST['id_voyage']) ? (int) $_POST['id_voyage'] : 0;
$statut = isset($_POST['statut']) ? $_POST['statut'] : '';

if (!in_array($statut, array('valide', 'refuse'))) {
    message_flash('error', 'Statut invalide.');
    rediriger('pages/inscriptions/gerer_inscriptions.php?id_voyage=' . $id_voyage);
}

$inscriptionModel = new Inscription();
$inscription = $inscriptionModel->trouverAvecVoyage($id_inscription, id_utilisateur());

if (!$inscription) {
    message_flash('error', 'Inscription introuvable.');
    rediriger('pages/voyages/mes_voyages.php');
}

// Deuxieme verification de capacite avant validation par le responsable.
if ($statut === 'valide' && $inscription['statut'] !== 'valide' && (int) $inscription['nb_valides'] >= (int) $inscription['nb_places']) {
    message_flash('error', 'Impossible de valider : le voyage est complet.');
    rediriger('pages/inscriptions/gerer_inscriptions.php?id_voyage=' . $id_voyage);
}

$inscriptionModel->changerStatut($id_inscription, id_utilisateur(), $statut);
message_flash('success', 'Statut de l inscription modifie.');
rediriger('pages/inscriptions/gerer_inscriptions.php?id_voyage=' . $id_voyage);

