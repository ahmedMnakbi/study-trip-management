<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Document.php';

require_connexion();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$document = (new Document())->trouverAvecAcces($id, utilisateur_connecte());

if (!$document) {
    http_response_code(404);
    echo 'Document introuvable.';
    exit;
}

$dossierUploads = realpath(__DIR__ . '/../../uploads/documents');
$chemin = realpath(__DIR__ . '/../../' . $document['chemin_fichier']);

if (!$dossierUploads || !$chemin || strpos($chemin, $dossierUploads . DIRECTORY_SEPARATOR) !== 0 || !is_file($chemin)) {
    http_response_code(404);
    echo 'Fichier introuvable.';
    exit;
}

$nom = preg_replace('/[^a-zA-Z0-9._-]+/', '_', $document['nom_original']);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $nom . '"');
header('Content-Length: ' . filesize($chemin));
readfile($chemin);
exit;
