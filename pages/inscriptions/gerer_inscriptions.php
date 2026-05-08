<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';
require_once __DIR__ . '/../../classes/Inscription.php';
require_once __DIR__ . '/../../classes/Document.php';

require_role('responsable');

$id_voyage = isset($_GET['id_voyage']) ? (int) $_GET['id_voyage'] : 0;
$voyage = (new Voyage())->trouverPourResponsable($id_voyage, id_utilisateur());

if (!$voyage) {
    message_flash('error', 'Voyage introuvable.');
    rediriger('pages/voyages/mes_voyages.php');
}

$inscriptions = (new Inscription())->listerParVoyageResponsable($id_voyage, id_utilisateur());
$documents = (new Document())->listerPourResponsable(id_utilisateur());

$titre_page = 'Gerer inscriptions';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Inscriptions - <?php echo e($voyage['titre']); ?></h1>
    <p>Places validees : <?php echo e($voyage['nb_inscrits_valides']); ?>/<?php echo e($voyage['nb_places']); ?></p>
</section>

<table>
    <thead>
        <tr>
            <th>Etudiant</th>
            <th>Email</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inscriptions as $inscription): ?>
            <tr>
                <td><?php echo e($inscription['prenom'] . ' ' . $inscription['nom']); ?></td>
                <td><?php echo e($inscription['email']); ?></td>
                <td><?php echo e(libelle_statut($inscription['statut'])); ?></td>
                <td>
                    <form method="post" action="<?php echo e(url('pages/inscriptions/changer_statut.php')); ?>">
                        <?php echo champ_csrf(); ?>
                        <input type="hidden" name="id_inscription" value="<?php echo e($inscription['id_inscription']); ?>">
                        <input type="hidden" name="id_voyage" value="<?php echo e($id_voyage); ?>">
                        <button type="submit" name="statut" value="valide">Valider</button>
                        <button type="submit" name="statut" value="refuse">Refuser</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Documents recus pour mes voyages</h2>
<table>
    <thead>
        <tr>
            <th>Etudiant</th>
            <th>Voyage</th>
            <th>Type</th>
            <th>Telechargement</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documents as $document): ?>
            <tr>
                <td><?php echo e($document['prenom'] . ' ' . $document['nom']); ?></td>
                <td><?php echo e($document['titre']); ?></td>
                <td><?php echo e($document['type_document']); ?></td>
                <td><a href="<?php echo e(url('pages/documents/telecharger_document.php?id=' . $document['id_document'])); ?>">Telecharger</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

