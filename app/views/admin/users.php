<section class="page-heading">
    <div>
        <p class="eyebrow">Comptes</p>
        <h1>Gestion des utilisateurs</h1>
        <p class="lede">Creez les comptes internes, changez les roles et activez ou desactivez les acces.</p>
    </div>
</section>

<form class="panel form wide-form" method="post" action="<?= e(url('admin/users/store')) ?>">
    <?= csrf_field() ?>
    <h2>Creer un utilisateur</h2>

    <div class="form-grid">
        <div>
            <label for="nom">Nom</label>
            <input id="nom" type="text" name="nom" value="<?= e($old['nom'] ?? '') ?>" required>
            <?php if (isset($errors['nom'])): ?>
                <p class="field-error"><?= e($errors['nom']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="prenom">Prenom</label>
            <input id="prenom" type="text" name="prenom" value="<?= e($old['prenom'] ?? '') ?>" required>
            <?php if (isset($errors['prenom'])): ?>
                <p class="field-error"><?= e($errors['prenom']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required>
            <?php if (isset($errors['email'])): ?>
                <p class="field-error"><?= e($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input id="mot_de_passe" type="password" name="mot_de_passe" minlength="6" required>
            <?php if (isset($errors['mot_de_passe'])): ?>
                <p class="field-error"><?= e($errors['mot_de_passe']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="role">Role</label>
            <select id="role" name="role">
                <?php foreach (['etudiant', 'responsable', 'admin', 'financier'] as $role): ?>
                    <option value="<?= e($role) ?>" <?= ($old['role'] ?? 'etudiant') === $role ? 'selected' : '' ?>><?= e($role) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['role'])): ?>
                <p class="field-error"><?= e($errors['role']) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <button class="button" type="submit">Creer l'utilisateur</button>
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Email</th>
                <th>Role</th>
                <th>Statut</th>
                <th>Date creation</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= e($user['prenom'] . ' ' . $user['nom']) ?></td>
                    <td><?= e($user['email']) ?></td>
                    <td><?= e($user['role']) ?></td>
                    <td><span class="badge <?= e($user['statut']) ?>"><?= e(status_label($user['statut'])) ?></span></td>
                    <td><?= e($user['date_creation']) ?></td>
                    <td>
                        <form class="inline-form stacked" method="post" action="<?= e(url('admin/users/update')) ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_user" value="<?= e((string) $user['id_user']) ?>">
                            <label class="sr-only" for="role-<?= e((string) $user['id_user']) ?>">Role</label>
                            <select id="role-<?= e((string) $user['id_user']) ?>" name="role">
                                <?php foreach (['etudiant', 'responsable', 'admin', 'financier'] as $role): ?>
                                    <option value="<?= e($role) ?>" <?= $user['role'] === $role ? 'selected' : '' ?>><?= e($role) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="sr-only" for="statut-<?= e((string) $user['id_user']) ?>">Statut</label>
                            <select id="statut-<?= e((string) $user['id_user']) ?>" name="statut">
                                <?php foreach (['actif', 'inactif'] as $statut): ?>
                                    <option value="<?= e($statut) ?>" <?= $user['statut'] === $statut ? 'selected' : '' ?>><?= e(status_label($statut)) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="button small" type="submit">Mettre a jour</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
