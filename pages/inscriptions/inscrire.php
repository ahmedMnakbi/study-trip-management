<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';
require_once __DIR__ . '/../../classes/Inscription.php';

require_role('etudiant');

if (!est_post()) {
    rediriger('pages/voyages/liste_voyages.php');
}

verifier_csrf();
$id_voyage = isset($_POST['id_voyage']) ? (int) $_POST['id_voyage'] : 0;
$voyageModel = new Voyage();
$inscriptionModel = new Inscription();
$voyage = $voyageModel->trouverParId($id_voyage);

if (!$voyage || $voyage['statut'] !== 'valide') {
    message_flash('error', 'Ce voyage nest pas ouvert aux inscriptions.');
    rediriger('pages/voyages/liste_voyages.php');
}

if ($inscriptionModel->existe(id_utilisateur(), $id_voyage)) {
    message_flash('error', 'Vous etes deja inscrit a ce voyage.');
    rediriger('pages/voyages/detail_voyage.php?id=' . $id_voyage);
}

// Regle metier simple: verifier les places avant d'ajouter une inscription.
if ($voyageModel->placesDisponiblesInscription($id_voyage) <= 0) {
    message_flash('error', 'Le voyage est complet.');
    rediriger('pages/voyages/detail_voyage.php?id=' . $id_voyage);
}

$inscriptionModel->creer(id_utilisateur(), $id_voyage);
message_flash('success', 'Inscription envoyee. Elle attend la validation du responsable.');
rediriger('pages/inscriptions/mes_inscriptions.php');
