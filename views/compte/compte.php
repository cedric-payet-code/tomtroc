<div class="container">
    <h1 class="page-title">Profil de <?= htmlspecialchars($user->getUsername()) ?></h1>

    <div class="account__panels">
        <div class="card profile-card">
            <img src="assets/images/<?= htmlspecialchars($user->getAvatar() ?? 'profil.jpg') ?>" alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>" class="profile-card__avatar">

            <hr class="profile-card__divider">

            <p class="profile-card__username"><?= htmlspecialchars($user->getUsername()) ?></p>
            <p class="profile-card__member-since">Membre depuis <?= htmlspecialchars($memberSince) ?></p>

            <p class="profile-card__label">Bibliothèque</p>
            <p class="profile-card__book-count"><?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>

            <a href="messagerie/nouveau/<?= htmlspecialchars($user->getId()) ?>" class="button button--outline profile-card__contact-button">
                Écrire un message
            </a>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <img src="assets/images/<?= htmlspecialchars($book->getImage() ?? 'livre.jpg') ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>" class="account-books__thumbnail">
                        </td>
                        <td>
                            <a href="livre/<?= htmlspecialchars($book->getId()) ?>">
                                <?= htmlspecialchars($book->getTitle()) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                        <td class="account-books__description">
                            <?= htmlspecialchars(mb_strimwidth($book->getDescription(), 0, 80, '...')) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>