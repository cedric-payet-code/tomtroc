<div class="container">
    <h1 class="account__title">Mon compte</h1>

    <div class="account__panels">
        <div class="card profile-card">
            <img src="assets/images/<?= htmlspecialchars($user->getAvatar() ?? 'profil.jpg') ?>" alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>" class="profile-card__avatar">
            <a href="compte/avatar" class="profile-card__edit-link">modifier</a>

            <hr class="profile-card__divider">

            <p class="profile-card__username"><?= htmlspecialchars($user->getUsername()) ?></p>
            <p class="profile-card__member-since">Membre depuis <?= htmlspecialchars($memberSince) ?></p>

            <p class="profile-card__label">Bibliothèque</p>
            <p class="profile-card__book-count"><?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>
        </div>

        <div class="card info-card">
            <h2 class="info-card__title">Vos informations personnelles</h2>

            <?php if (!empty($errors)): ?>
                <div class="auth__errors">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="mon-compte" method="post">
                <div class="form-field">
                    <label for="email" class="form-field__label">Adresse email</label>
                    <input type="email" name="email" id="email" class="form-field__input" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                </div>

                <div class="form-field">
                    <label for="password" class="form-field__label">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-field__input" placeholder="••••••••">
                </div>

                <div class="form-field">
                    <label for="username" class="form-field__label">Pseudo</label>
                    <input type="text" name="username" id="username" class="form-field__input" value="<?= htmlspecialchars($user->getUsername()) ?>" required>
                </div>

                <button type="submit" class="button button--outline">Enregistrer</button>
            </form>
        </div>
    </div>

    <div class="card account-books">
        <table class="account-books__table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Description</th>
                    <th>Disponibilité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <img src="assets/images/<?= htmlspecialchars($book->getImage() ?? 'livre.jpg') ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>" class="account-books__thumbnail">
                        </td>
                        <td><?= htmlspecialchars($book->getTitle()) ?></td>
                        <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                        <td class="account-books__description">
                            <?= htmlspecialchars(mb_strimwidth($book->getDescription(), 0, 80, '...')) ?>
                        </td>
                        <td>
                            <?php if ($book->isAvailable()): ?>
                                <span class="status-badge status-badge--available">disponible</span>
                            <?php else: ?>
                                <span class="status-badge status-badge--unavailable">non dispo.</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="livre/<?= htmlspecialchars($book->getId()) ?>/editer" class="account-books__action-link">Éditer</a>
                            <a href="livre/<?= htmlspecialchars($book->getId()) ?>/delete" class="account-books__action-link account-books__action-link--delete">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>