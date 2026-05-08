<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';

require_role('admin');
$voyageModel = new Voyage();

if (est_post()) {
    verifier_csrf();
    $id_voyage = isset($_POST['id_voyage']) ? (int) $_POST['id_voyage'] : 0;
    $statut = isset($_POST['statut']) ? $_POST['statut'] : '';

    if (in_array($statut, array('valide', 'refuse', 'annule'))) {
        $voyageModel->changerStatut($id_voyage, $statut);
        message_flash('success', 'Statut du voyage modifie.');
    }

    rediriger('pages/voyages/valider_voyages.php');
}

$voyages = $voyageModel->listerTous();
$titre_page = 'Validation des voyages';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Validation des voyages</h1>
</section>

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Responsable</th>
            <th>Destination</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($voyages as $voyage): ?>
            <tr>
                <td><?php echo e($voyage['titre']); ?></td>
                <td><?php echo e($voyage['responsable_prenom'] . ' ' . $voyage['responsable_nom']); ?></td>
                <td><?php echo e($voyage['destination']); ?></td>
                <td><?php echo e(libelle_statut($voyage['statut'])); ?></td>
                <td class="actions-inline">
                    <form method="post">
                        <?php echo champ_csrf(); ?>
                        <input type="hidden" name="id_voyage" value="<?php echo e($voyage['id_voyage']); ?>">
                        <button type="submit" name="statut" value="valide">Valider</button>
                        <button type="submit" name="statut" value="refuse">Refuser</button>
                        <button class="danger" type="submit" name="statut" value="annule">Annuler</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

