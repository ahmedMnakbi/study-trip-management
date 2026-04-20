<section class="page-heading">
    <div>
        <p class="eyebrow">Documents</p>
        <h1>Mes documents</h1>
        <p class="lede">Retrouvez les fichiers deposes pour vos voyages d'etudes.</p>
    </div>
    <a class="button secondary" href="<?= e(url('mes-inscriptions')) ?>">Deposer un document</a>
</section>

<?php if ($documents === []): ?>
    <section class="empty-state">
        <h2>Aucun document</h2>
        <p>Les documents deposes depuis vos inscriptions apparaitront ici.</p>
    </section>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Voyage</th>
                    <th>Destination</th>
                    <th>Date depot</th>
                    <th>Fichier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $document): ?>
                    <tr>
                        <td><?= e($document['type_document']) ?></td>
                        <td><?= e($document['titre'] ?? 'Non lie') ?></td>
                        <td><?= e($document['destination'] ?? '-') ?></td>
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
