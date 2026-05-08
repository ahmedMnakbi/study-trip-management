<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Inscription.php';
require_once __DIR__ . '/../../classes/Document.php';

require_role('etudiant');

if (!est_post()) {
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

verifier_csrf();

$id_voyage = isset($_POST['id_voyage']) ? (int) $_POST['id_voyage'] : 0;
$type_document = trim(isset($_POST['type_document']) ? $_POST['type_document'] : '');

if ($type_document === '') {
    message_flash('error', 'Le type de document est obligatoire.');
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

if (!(new Inscription())->existe(id_utilisateur(), $id_voyage)) {
    message_flash('error', 'Vous devez etre inscrit a ce voyage pour envoyer un document.');
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

if (!isset($_FILES['document']) || $_FILES['document']['error'] !== UPLOAD_ERR_OK) {
    message_flash('error', 'Aucun fichier valide selectionne.');
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

$fichier = $_FILES['document'];
$max = 5 * 1024 * 1024;
$extensions = array('pdf', 'jpg', 'jpeg', 'png');
$mimes = array('application/pdf', 'image/jpeg', 'image/png');
$extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

if ($fichier['size'] > $max) {
    message_flash('error', 'Le fichier ne doit pas depasser 5 Mo.');
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

if (!in_array($extension, $extensions)) {
    message_flash('error', 'Formats acceptes : PDF, JPG, JPEG, PNG.');
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

// Verification MIME simple en plus de l'extension.
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $fichier['tmp_name']);
finfo_close($finfo);

if (!in_array($mime, $mimes)) {
    message_flash('error', 'Type de fichier refuse.');
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

$dossier = __DIR__ . '/../../uploads/documents';
if (!is_dir($dossier)) {
    mkdir($dossier, 0775, true);
}

$nom_fichier = date('YmdHis') . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
$destination = $dossier . '/' . $nom_fichier;

if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
    message_flash('error', 'Impossible d enregistrer le fichier.');
    rediriger('pages/inscriptions/mes_inscriptions.php');
}

(new Document())->creer(array(
    'id_user' => id_utilisateur(),
    'id_voyage' => $id_voyage,
    'type_document' => $type_document,
    'nom_original' => $fichier['name'],
    'chemin_fichier' => 'uploads/documents/' . $nom_fichier
));

message_flash('success', 'Document envoye avec succes.');
rediriger('pages/documents/mes_documents.php');

