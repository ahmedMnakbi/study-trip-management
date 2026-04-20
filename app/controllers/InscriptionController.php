<?php

declare(strict_types=1);

class InscriptionController extends Controller
{
    public function store(): void
    {
        Auth::requireRole('etudiant');
        verify_csrf();

        $voyageId = (int) ($_POST['id_voyage'] ?? 0);
        $voyageModel = new Voyage();
        $inscriptionModel = new Inscription();
        $voyage = $voyageModel->find($voyageId);

        if (!$voyage || $voyage['statut'] !== 'valide') {
            flash('error', "Ce voyage n'est pas ouvert aux inscriptions.");
            redirect('voyages');
        }

        if ($inscriptionModel->exists(Auth::id(), $voyageId)) {
            flash('error', 'Vous etes deja inscrit a ce voyage.');
            redirect('voyage/show', ['id' => $voyageId]);
        }

        $isFull = (int) $voyage['places_restantes'] <= 0;
        $inscriptionModel->create(Auth::id(), $voyageId, $isFull ? 'refuse' : 'en_attente');

        if ($isFull) {
            flash('error', "Le voyage est complet. Votre inscription a ete refusee automatiquement.");
        } else {
            flash('success', 'Inscription envoyee. Elle est en attente de validation.');
        }

        redirect('mes-inscriptions');
    }

    public function mine(): void
    {
        Auth::requireRole('etudiant');

        $this->view('inscriptions/mine', [
            'title' => 'Mes inscriptions',
            'inscriptions' => (new Inscription())->forStudent(Auth::id()),
            'documentsByVoyage' => (new Document())->groupByVoyageForStudent(Auth::id()),
        ]);
    }

    public function updateStatus(): void
    {
        Auth::requireRole('responsable');
        verify_csrf();

        $id = (int) ($_POST['id_inscription'] ?? 0);
        $status = (string) ($_POST['statut'] ?? '');

        if (!in_array($status, ['valide', 'refuse'], true)) {
            flash('error', 'Statut invalide.');
            redirect('responsable/voyages');
        }

        $updated = (new Inscription())->updateStatusForResponsible($id, Auth::id(), $status);
        flash($updated ? 'success' : 'error', $updated ? 'Inscription mise a jour.' : 'Action impossible.');

        $voyageId = (int) ($_POST['id_voyage'] ?? 0);
        redirect('responsable/inscriptions', ['id' => $voyageId]);
    }
}
