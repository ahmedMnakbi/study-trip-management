<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Document.php';

require_role('etudiant');

$documents = (new Document())->listerParEtudiant(id_utilisateur());
$titre_page = 'Mes documents';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Mes documents</h1>
</section>

<table>
    <thead>
        <tr>
            <th>Voyage</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Fichier</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documents as $document): ?>
            <tr>
                <td><?php echo e($document['titre']); ?></td>
                <td><?php echo e($document['type_document']); ?></td>
                <td><?php echo e(libelle_statut($document['statut'])); ?></td>
                <td><?php echo e($document['date_upload']); ?></td>
                <td><a href="<?php echo e(url('pages/documents/telecharger_document.php?id=' . $document['id_document'])); ?>">Telecharger</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (empty($documents)): ?>
    <p>Aucun document envoye.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

