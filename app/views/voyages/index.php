<section class="page-heading">
    <div>
        <p class="eyebrow">Voyages valides</p>
        <h1>Voyages disponibles</h1>
        <p class="lede">Consultez les voyages ouverts et envoyez votre demande d'inscription.</p>
    </div>

    <form class="search-form" method="get" action="<?= e($_SERVER['SCRIPT_NAME']) ?>">
        <input type="hidden" name="route" value="voyages">
        <label class="sr-only" for="q">Recherche</label>
        <input id="q" type="search" name="q" value="<?= e($search ?? '') ?>" placeholder="Destination ou titre">
        <button class="button secondary" type="submit">Rechercher</button>
    </form>
</section>

<?php if ($voyages === []): ?>
    <section class="empty-state">
        <h2>Aucun voyage disponible</h2>
        <p>Les voyages valides apparaitront ici apres validation par l'administrateur.</p>
    </section>
<?php else: ?>
    <section class="cards-grid">
        <?php foreach ($voyages as $voyage): ?>
            <article class="travel-card">
                <div>
                    <span class="badge <?= e($voyage['statut']) ?>"><?= e(status_label($voyage['statut'])) ?></span>
                    <h2><?= e($voyage['titre']) ?></h2>
                    <p class="destination"><?= e($voyage['destination']) ?></p>
                    <p><?= e(excerpt($voyage['description'])) ?></p>
                </div>

                <dl class="meta-grid">
                    <div>
                        <dt>Depart</dt>
                        <dd><?= e($voyage['date_depart']) ?></dd>
                    </div>
                    <div>
                        <dt>Places</dt>
                        <dd><?= e((string) $voyage['places_restantes']) ?>/<?= e((string) $voyage['nb_places']) ?></dd>
                    </div>
                    <div>
                        <dt>Budget</dt>
                        <dd><?= e(number_format((float) $voyage['budget'], 2)) ?> TND</dd>
                    </div>
                </dl>

                <a class="button" href="<?= e(url('voyage/show', ['id' => $voyage['id_voyage']])) ?>">Voir details</a>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
