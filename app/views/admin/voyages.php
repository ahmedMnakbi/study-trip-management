<section class="page-heading">
    <div>
        <p class="eyebrow">Validation administrative</p>
        <h1>Gestion des voyages</h1>
        <p class="lede">Validez, refusez ou archivez les voyages proposes par les responsables.</p>
    </div>
</section>

<?php if ($voyages === []): ?>
    <section class="empty-state">
        <h2>Aucun voyage</h2>
        <p>Les propositions des responsables apparaitront ici.</p>
    </section>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Destination</th>
                    <th>Responsable</th>
                    <th>Dates</th>
                    <th>Places</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voyages as $voyage): ?>
                    <tr>
                        <td><?= e($voyage['titre']) ?></td>
                        <td><?= e($voyage['destination']) ?></td>
                        <td><?= e($voyage['responsable_prenom'] . ' ' . $voyage['responsable_nom']) ?></td>
                        <td><?= e($voyage['date_depart']) ?> au <?= e($voyage['date_retour']) ?></td>
                        <td><?= e((string) $voyage['nb_inscrits']) ?>/<?= e((string) $voyage['nb_places']) ?></td>
                        <td><span class="badge <?= e($voyage['statut']) ?>"><?= e(status_label($voyage['statut'])) ?></span></td>
                        <td class="actions">
                            <form method="post" action="<?= e(url('admin/voyage/validate')) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_voyage" value="<?= e((string) $voyage['id_voyage']) ?>">
                                <button class="button small" type="submit">Valider</button>
                            </form>
                            <form method="post" action="<?= e(url('admin/voyage/refuse')) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_voyage" value="<?= e((string) $voyage['id_voyage']) ?>">
                                <button class="button small danger" type="submit">Refuser</button>
                            </form>
                            <form method="post" action="<?= e(url('admin/voyage/archive')) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_voyage" value="<?= e((string) $voyage['id_voyage']) ?>">
                                <button class="button small secondary" type="submit">Archiver</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
