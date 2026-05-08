<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';

require_role('responsable');

$voyageModel = new Voyage();
$voyages = $voyageModel->listerParResponsable(id_utilisateur());

$titre_page = 'Mes voyages';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title actions">
    <div>
        <h1>Mes voyages</h1>
        <p>Un responsable propose un voyage, puis l'administrateur le valide.</p>
    </div>
    <a class="button" href="<?php echo e(url('pages/voyages/ajouter_voyage.php')); ?>">Ajouter un voyage</a>
</section>

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Destination</th>
            <th>Dates</th>
            <th>Places</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($voyages as $voyage): ?>
            <tr>
                <td><?php echo e($voyage['titre']); ?></td>
                <td><?php echo e($voyage['destination']); ?></td>
                <td><?php echo e($voyage['date_depart']); ?> - <?php echo e($voyage['date_retour']); ?></td>
                <td><?php echo e($voyage['nb_inscrits_valides']); ?>/<?php echo e($voyage['nb_places']); ?></td>
                <td><?php echo e(libelle_statut($voyage['statut'])); ?></td>
                <td class="actions-inline">
                    <a href="<?php echo e(url('pages/voyages/modifier_voyage.php?id=' . $voyage['id_voyage'])); ?>">Modifier</a>
                    <a href="<?php echo e(url('pages/inscriptions/gerer_inscriptions.php?id_voyage=' . $voyage['id_voyage'])); ?>">Inscriptions</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

