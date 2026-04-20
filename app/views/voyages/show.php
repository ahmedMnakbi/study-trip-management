<section class="detail-layout">
    <article class="panel">
        <span class="badge <?= e($voyage['statut']) ?>"><?= e(status_label($voyage['statut'])) ?></span>
        <h1><?= e($voyage['titre']) ?></h1>
        <p class="destination"><?= e($voyage['destination']) ?></p>
        <p><?= nl2br(e($voyage['description'])) ?></p>

        <dl class="detail-list">
            <div>
                <dt>Date depart</dt>
                <dd><?= e($voyage['date_depart']) ?></dd>
            </div>
            <div>
                <dt>Date retour</dt>
                <dd><?= e($voyage['date_retour']) ?></dd>
            </div>
            <div>
                <dt>Budget</dt>
                <dd><?= e(number_format((float) $voyage['budget'], 2)) ?> TND</dd>
            </div>
            <div>
                <dt>Places restantes</dt>
                <dd><?= e((string) $voyage['places_restantes']) ?> / <?= e((string) $voyage['nb_places']) ?></dd>
            </div>
            <div>
                <dt>Responsable</dt>
                <dd><?= e($voyage['responsable_prenom'] . ' ' . $voyage['responsable_nom']) ?></dd>
            </div>
        </dl>
    </article>

    <aside class="panel action-panel">
        <?php if (Auth::role() === 'etudiant' && $voyage['statut'] === 'valide'): ?>
            <?php if ($alreadyRegistered): ?>
                <h2>Inscription deja envoyee</h2>
                <p>Vous pouvez suivre son statut depuis votre historique.</p>
                <a class="button secondary" href="<?= e(url('mes-inscriptions')) ?>">Mes inscriptions</a>
            <?php elseif ((int) $voyage['places_restantes'] <= 0): ?>
                <h2>Voyage complet</h2>
                <p>Une demande envoyee maintenant sera refusee automatiquement.</p>
                <form method="post" action="<?= e(url('inscription/store')) ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_voyage" value="<?= e((string) $voyage['id_voyage']) ?>">
                    <button class="button danger" type="submit">Envoyer quand meme</button>
                </form>
            <?php else: ?>
                <h2>Demande d'inscription</h2>
                <p>Votre demande sera transmise au responsable pedagogique.</p>
                <form method="post" action="<?= e(url('inscription/store')) ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_voyage" value="<?= e((string) $voyage['id_voyage']) ?>">
                    <button class="button" type="submit">S'inscrire</button>
                </form>
            <?php endif; ?>
        <?php elseif (!Auth::check()): ?>
            <h2>Connexion requise</h2>
            <p>Connectez-vous avec un compte etudiant pour envoyer une demande.</p>
            <a class="button" href="<?= e(url('login')) ?>">Se connecter</a>
        <?php else: ?>
            <h2>Consultation</h2>
            <p>Les inscriptions sont reservees aux comptes etudiants.</p>
        <?php endif; ?>
    </aside>
</section>
