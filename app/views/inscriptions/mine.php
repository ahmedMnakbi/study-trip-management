<section class="page-heading">
    <div>
        <p class="eyebrow">Historique</p>
        <h1>Mes inscriptions</h1>
        <p class="lede">Suivez l'etat de vos demandes de participation.</p>
    </div>
</section>

<?php if ($inscriptions === []): ?>
    <section class="empty-state">
        <h2>Aucune inscription</h2>
        <p>Consultez les voyages disponibles pour envoyer votre premiere demande.</p>
        <a class="button" href="<?= e(url('voyages')) ?>">Voir les voyages</a>
    </section>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Voyage</th>
                    <th>Destination</th>
                    <th>Depart</th>
                    <th>Date inscription</th>
                    <th>Statut</th>
                    <th>Documents</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscriptions as $inscription): ?>
                    <tr>
                        <td><?= e($inscription['titre']) ?></td>
                        <td><?= e($inscription['destination']) ?></td>
                        <td><?= e($inscription['date_depart']) ?></td>
                        <td><?= e($inscription['date_inscription']) ?></td>
                        <td><span class="badge <?= e($inscription['statut']) ?>"><?= e(status_label($inscription['statut'])) ?></span></td>
                        <td class="documents-cell">
                            <?php $voyageDocuments = $documentsByVoyage[(int) $inscription['id_voyage']] ?? []; ?>
                            <?php if ($voyageDocuments !== []): ?>
                                <ul class="compact-list">
                                    <?php foreach ($voyageDocuments as $document): ?>
                                        <li>
                                            <a href="<?= e(url('document/download', ['id' => $document['id_document']])) ?>">
                                                <?= e($document['type_document']) ?>
                                            </a>
                                            <span class="muted"><?= e($document['date_upload']) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="muted">Aucun document.</p>
                            <?php endif; ?>

                            <form class="upload-form" method="post" action="<?= e(url('document/upload')) ?>" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_voyage" value="<?= e((string) $inscription['id_voyage']) ?>">

                                <label for="type_document_<?= e((string) $inscription['id_inscription']) ?>">Type</label>
                                <input id="type_document_<?= e((string) $inscription['id_inscription']) ?>" type="text" name="type_document" placeholder="Autorisation, carte..." required>

                                <label for="document_<?= e((string) $inscription['id_inscription']) ?>">Fichier</label>
                                <input id="document_<?= e((string) $inscription['id_inscription']) ?>" type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" required data-file-check>
                                <p class="js-hint" data-file-hint>Formats acceptes : PDF, JPG, JPEG, PNG. Taille maximale : 5 Mo.</p>

                                <button class="button small" type="submit">Deposer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
