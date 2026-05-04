<section class="page-heading">
    <div>
        <p class="eyebrow">Validation pedagogique</p>
        <h1><?= e($voyage['titre']) ?></h1>
        <p class="lede"><?= e($voyage['destination']) ?>, <?= e((string) $voyage['nb_inscrits']) ?> inscription(s) active(s) sur <?= e((string) $voyage['nb_places']) ?> places.</p>
    </div>
    <a class="button secondary" href="<?= e(url('responsable/voyages')) ?>">Retour</a>
</section>

<?php if ($inscriptions === []): ?>
    <section class="empty-state">
        <h2>Aucune inscription</h2>
        <p>Les demandes des etudiants apparaitront ici.</p>
    </section>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Etudiant</th>
                    <th>Email</th>
                    <th>Date demande</th>
                    <th>Statut</th>
                    <th>Decision</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscriptions as $inscription): ?>
                    <tr>
                        <td><?= e($inscription['prenom'] . ' ' . $inscription['nom']) ?></td>
                        <td><?= e($inscription['email']) ?></td>
                        <td><?= e($inscription['date_inscription']) ?></td>
                        <td><span class="badge <?= e($inscription['statut']) ?>"><?= e(status_label($inscription['statut'])) ?></span></td>
                        <td class="actions">
                            <form method="post" action="<?= e(url('inscription/status')) ?>" data-confirm="Valider cette inscription ?">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_inscription" value="<?= e((string) $inscription['id_inscription']) ?>">
                                <input type="hidden" name="id_voyage" value="<?= e((string) $voyage['id_voyage']) ?>">
                                <input type="hidden" name="statut" value="valide">
                                <button class="button small" type="submit">Valider</button>
                            </form>
                            <form method="post" action="<?= e(url('inscription/status')) ?>" data-confirm="Refuser cette inscription ?">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_inscription" value="<?= e((string) $inscription['id_inscription']) ?>">
                                <input type="hidden" name="id_voyage" value="<?= e((string) $voyage['id_voyage']) ?>">
                                <input type="hidden" name="statut" value="refuse">
                                <button class="button small danger" type="submit">Refuser</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<section class="section-block">
    <div class="page-heading compact">
        <div>
            <p class="eyebrow">Documents recus</p>
            <h2>Pieces deposees par les etudiants</h2>
        </div>
    </div>

    <?php if ($documents === []): ?>
        <section class="empty-state">
            <h2>Aucun document</h2>
            <p>Les fichiers transmis par les etudiants apparaitront ici.</p>
        </section>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Etudiant</th>
                        <th>Email</th>
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
</section>
