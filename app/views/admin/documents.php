<section class="page-heading">
    <div>
        <p class="eyebrow">Suivi administratif</p>
        <h1>Documents deposes</h1>
        <p class="lede">Controlez les documents transmis par les etudiants pour les voyages.</p>
    </div>
</section>

<?php if ($documents === []): ?>
    <section class="empty-state">
        <h2>Aucun document</h2>
        <p>Les documents transmis par les etudiants apparaitront ici.</p>
    </section>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Etudiant</th>
                    <th>Email</th>
                    <th>Voyage</th>
                    <th>Type</th>
                    <th>Date depot</th>
                    <th>Fichier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $document): ?>
                    <tr>
                        <td><?= e($document['prenom'] . ' ' . $document['nom']) ?></td>
                        <td><?= e($document['email']) ?></td>
                        <td><?= e(($document['titre'] ?? 'Non lie') . ' - ' . ($document['destination'] ?? '-')) ?></td>
                        <td><?= e($document['type_document']) ?></td>
                        <td><?= e($document['date_upload']) ?></td>
                        <td>
                            <a class="button small secondary" href="<?= e(url('document/download', ['id' => $document['id_document']])) ?>">
                                Telecharger
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
