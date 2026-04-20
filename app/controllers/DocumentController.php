<?php

declare(strict_types=1);

class DocumentController extends Controller
{
    private const MAX_SIZE = 5242880;
    private const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png'];

    public function mine(): void
    {
        Auth::requireRole('etudiant');

        $this->view('documents/mine', [
            'title' => 'Mes documents',
            'documents' => (new Document())->forStudent(Auth::id()),
        ]);
    }

    public function adminIndex(): void
    {
        Auth::requireRole('admin');

        $this->view('admin/documents', [
            'title' => 'Documents',
            'documents' => (new Document())->all(),
        ]);
    }

    public function upload(): void
    {
        Auth::requireRole('etudiant');
        verify_csrf();

        $voyageId = (int) ($_POST['id_voyage'] ?? 0);
        $type = trim((string) ($_POST['type_document'] ?? ''));
        $inscriptionModel = new Inscription();

        if ($voyageId <= 0 || !$inscriptionModel->exists(Auth::id(), $voyageId)) {
            flash('error', "Vous devez etre inscrit a ce voyage pour deposer un document.");
            redirect('mes-inscriptions');
        }

        if ($type === '') {
            flash('error', 'Le type de document est obligatoire.');
            redirect('mes-inscriptions');
        }

        if (!isset($_FILES['document']) || !is_array($_FILES['document'])) {
            flash('error', 'Aucun fichier selectionne.');
            redirect('mes-inscriptions');
        }

        $file = $_FILES['document'];
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            flash('error', "Le fichier n'a pas pu etre envoye.");
            redirect('mes-inscriptions');
        }

        if ((int) $file['size'] > self::MAX_SIZE) {
            flash('error', 'Le fichier ne doit pas depasser 5 Mo.');
            redirect('mes-inscriptions');
        }

        $originalName = (string) ($file['name'] ?? '');
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            flash('error', 'Formats acceptes : PDF, JPG, JPEG, PNG.');
            redirect('mes-inscriptions');
        }

        $uploadDir = BASE_PATH . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'documents';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $fileName = date('YmdHis') . '_' . bin2hex(random_bytes(12)) . '.' . $extension;
        $target = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (!move_uploaded_file((string) $file['tmp_name'], $target)) {
            flash('error', "Impossible d'enregistrer le fichier.");
            redirect('mes-inscriptions');
        }

        (new Document())->create([
            'id_user' => Auth::id(),
            'id_voyage' => $voyageId,
            'type_document' => $type,
            'chemin_fichier' => 'uploads/documents/' . $fileName,
        ]);

        flash('success', 'Document depose avec succes.');
        redirect('mes-inscriptions');
    }

    public function download(): void
    {
        Auth::requireLogin();

        $id = (int) ($_GET['id'] ?? 0);
        $document = (new Document())->findWithContext($id);

        if (!$document || !$this->canAccess($document)) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Document introuvable']);
            return;
        }

        $path = BASE_PATH . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $document['chemin_fichier']);
        if (!is_file($path)) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Document introuvable']);
            return;
        }

        $downloadName = preg_replace('/[^a-zA-Z0-9._-]+/', '_', $document['type_document']) . '.' . pathinfo($path, PATHINFO_EXTENSION);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $downloadName . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    private function canAccess(array $document): bool
    {
        if (Auth::role() === 'admin') {
            return true;
        }

        if (Auth::role() === 'responsable') {
            return (int) ($document['id_responsable'] ?? 0) === Auth::id();
        }

        return Auth::role() === 'etudiant' && (int) $document['id_user'] === Auth::id();
    }
}
