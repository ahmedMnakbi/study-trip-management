<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Document.php';

require_role('admin');

$documents = (new Document())->listerTous();
$titre_page = 'Tous les documents';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Tous les documents</h1>
</section>

<table>
    <thead>
        <tr>
            <th>Etudiant</th>
            <th>Voyage</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Fichier</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documents as $document): ?>
            <tr>
                <td><?php echo e($document['prenom'] . ' ' . $document['nom']); ?></td>
                <td><?php echo e($document['titre']); ?></td>
                <td><?php echo e($document['type_document']); ?></td>
                <td><?php echo e(libelle_statut($document['statut'])); ?></td>
                <td><a href="<?php echo e(url('pages/documents/telecharger_document.php?id=' . $document['id_document'])); ?>">Telecharger</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

