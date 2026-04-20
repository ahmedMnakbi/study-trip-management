<section class="page-heading">
    <div>
        <p class="eyebrow">Espace responsable</p>
        <h1>Mes voyages</h1>
        <p class="lede">Creez des voyages, suivez leur validation et gerez les inscriptions.</p>
    </div>
    <a class="button" href="<?= e(url('responsable/voyage/create')) ?>">Creer un voyage</a>
</section>

<?php if ($voyages === []): ?>
    <section class="empty-state">
        <h2>Aucun voyage cree</h2>
        <p>Votre prochain voyage apparaitra ici en attente de validation admin.</p>
    </section>
<?php else: ?>
    <div class="table-wrap">
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
                        <td><?= e($voyage['titre']) ?></td>
                        <td><?= e($voyage['destination']) ?></td>
                        <td><?= e($voyage['date_depart']) ?> au <?= e($voyage['date_retour']) ?></td>
                        <td><?= e((string) $voyage['nb_inscrits']) ?>/<?= e((string) $voyage['nb_places']) ?></td>
                        <td><span class="badge <?= e($voyage['statut']) ?>"><?= e(status_label($voyage['statut'])) ?></span></td>
                        <td class="actions">
                            <a class="button small secondary" href="<?= e(url('responsable/voyage/edit', ['id' => $voyage['id_voyage']])) ?>">Modifier</a>
                            <a class="button small secondary" href="<?= e(url('responsable/inscriptions', ['id' => $voyage['id_voyage']])) ?>">Inscriptions</a>
                            <?php if ($voyage['statut'] !== 'archive'): ?>
                                <form method="post" action="<?= e(url('responsable/voyage/archive')) ?>" data-confirm="Archiver ce voyage ?">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= e((string) $voyage['id_voyage']) ?>">
                                    <button class="button small danger" type="submit">Archiver</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
