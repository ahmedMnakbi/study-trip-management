<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Inscription.php';

require_role('etudiant');

$inscriptionModel = new Inscription();
$inscriptions = $inscriptionModel->listerParEtudiant(id_utilisateur());

$titre_page = 'Mes inscriptions';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Mes inscriptions</h1>
</section>

<table>
    <thead>
        <tr>
            <th>Voyage</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Document</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inscriptions as $inscription): ?>
            <tr>
                <td><?php echo e($inscription['titre']); ?></td>
                <td><?php echo e($inscription['destination']); ?></td>
                <td><?php echo e($inscription['date_depart']); ?></td>
                <td><?php echo e(libelle_statut($inscription['statut'])); ?></td>
                <td>
                    <form method="post" action="<?php echo e(url('pages/documents/upload_document.php')); ?>" enctype="multipart/form-data" data-form-upload>
                        <?php echo champ_csrf(); ?>
                        <input type="hidden" name="id_voyage" value="<?php echo e($inscription['id_voyage']); ?>">
                        <input type="text" name="type_document" placeholder="Type document" required>
                        <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" data-file required>
                        <button type="submit">Uploader</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (empty($inscriptions)): ?>
    <p>Vous n'avez pas encore d'inscription.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

