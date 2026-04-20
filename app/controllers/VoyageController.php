<?php

declare(strict_types=1);

class VoyageController extends Controller
{
    public function index(): void
    {
        $search = trim((string) ($_GET['q'] ?? ''));
        $voyageModel = new Voyage();

        $this->view('voyages/index', [
            'title' => 'Voyages disponibles',
            'voyages' => $voyageModel->validated($search),
            'search' => $search,
        ]);
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $voyage = (new Voyage())->find($id);

        if (!$voyage) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Voyage introuvable']);
            return;
        }

        $alreadyRegistered = false;
        if (Auth::role() === 'etudiant') {
            $alreadyRegistered = (new Inscription())->exists(Auth::id(), $id);
        }

        $this->view('voyages/show', [
            'title' => $voyage['titre'],
            'voyage' => $voyage,
            'alreadyRegistered' => $alreadyRegistered,
        ]);
    }

    public function mine(): void
    {
        Auth::requireRole('responsable');

        $voyages = (new Voyage())->byResponsible(Auth::id());
        $this->view('responsable/voyages', [
            'title' => 'Mes voyages',
            'voyages' => $voyages,
        ]);
    }

    public function create(): void
    {
        Auth::requireRole('responsable');

        $this->view('responsable/form', [
            'title' => 'Creer un voyage',
            'voyage' => null,
            'errors' => [],
            'action' => url('responsable/voyage/store'),
        ]);
    }

    public function store(): void
    {
        Auth::requireRole('responsable');
        verify_csrf();

        [$data, $errors] = $this->validatedVoyageInput();

        if ($errors !== []) {
            $this->view('responsable/form', [
                'title' => 'Creer un voyage',
                'voyage' => $data,
                'errors' => $errors,
                'action' => url('responsable/voyage/store'),
            ]);
            return;
        }

        $data['id_responsable'] = Auth::id();
        (new Voyage())->create($data);

        flash('success', "Voyage cree. Il attend la validation de l'administrateur.");
        redirect('responsable/voyages');
    }

    public function edit(): void
    {
        Auth::requireRole('responsable');

        $id = (int) ($_GET['id'] ?? 0);
        $voyage = (new Voyage())->find($id);

        if (!$voyage || (int) $voyage['id_responsable'] !== Auth::id()) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Voyage introuvable']);
            return;
        }

        $this->view('responsable/form', [
            'title' => 'Modifier le voyage',
            'voyage' => $voyage,
            'errors' => [],
            'action' => url('responsable/voyage/update', ['id' => $id]),
        ]);
    }

    public function update(): void
    {
        Auth::requireRole('responsable');
        verify_csrf();

        $id = (int) ($_GET['id'] ?? 0);
        [$data, $errors] = $this->validatedVoyageInput();

        if ($errors !== []) {
            $data['id_voyage'] = $id;
            $this->view('responsable/form', [
                'title' => 'Modifier le voyage',
                'voyage' => $data,
                'errors' => $errors,
                'action' => url('responsable/voyage/update', ['id' => $id]),
            ]);
            return;
        }

        $updated = (new Voyage())->update($id, Auth::id(), $data);
        flash($updated ? 'success' : 'error', $updated ? 'Voyage mis a jour.' : 'Voyage introuvable.');
        redirect('responsable/voyages');
    }

    public function inscriptions(): void
    {
        Auth::requireRole('responsable');

        $id = (int) ($_GET['id'] ?? 0);
        $voyage = (new Voyage())->find($id);

        if (!$voyage || (int) $voyage['id_responsable'] !== Auth::id()) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Voyage introuvable']);
            return;
        }

        $this->view('responsable/inscriptions', [
            'title' => 'Inscriptions - ' . $voyage['titre'],
            'voyage' => $voyage,
            'inscriptions' => (new Inscription())->forVoyage($id),
            'documents' => (new Document())->forVoyage($id),
        ]);
    }

    public function archive(): void
    {
        Auth::requireRole('responsable');
        verify_csrf();

        $id = (int) ($_POST['id'] ?? 0);
        $updated = (new Voyage())->updateStatusForResponsible($id, Auth::id(), 'archive');

        flash($updated ? 'success' : 'error', $updated ? 'Voyage archive.' : 'Action impossible.');
        redirect('responsable/voyages');
    }

    private function validatedVoyageInput(): array
    {
        $data = [
            'titre' => trim((string) ($_POST['titre'] ?? '')),
            'destination' => trim((string) ($_POST['destination'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'date_depart' => trim((string) ($_POST['date_depart'] ?? '')),
            'date_retour' => trim((string) ($_POST['date_retour'] ?? '')),
            'budget' => trim((string) ($_POST['budget'] ?? '0')),
            'nb_places' => trim((string) ($_POST['nb_places'] ?? '')),
        ];

        $errors = $this->validateRequired($data, [
            'titre' => 'Titre',
            'destination' => 'Destination',
            'description' => 'Description',
            'date_depart' => 'Date depart',
            'date_retour' => 'Date retour',
            'nb_places' => 'Nombre de places',
        ]);

        if ($data['date_depart'] !== '' && $data['date_retour'] !== '' && $data['date_retour'] < $data['date_depart']) {
            $errors['date_retour'] = 'La date retour doit etre apres la date depart.';
        }

        if (!is_numeric($data['budget']) || (float) $data['budget'] < 0) {
            $errors['budget'] = 'Budget invalide.';
        }

        if (!ctype_digit($data['nb_places']) || (int) $data['nb_places'] < 1) {
            $errors['nb_places'] = 'Le nombre de places doit etre positif.';
        }

        $data['budget'] = (float) $data['budget'];
        $data['nb_places'] = (int) $data['nb_places'];

        return [$data, $errors];
    }
}
