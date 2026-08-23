<nav class="breadcrumb container">
    <a href="nos-livres">Nos livres</a> &gt; <?= htmlspecialchars($book->getTitle()) ?>
</nav>

<section class="split-screen">
    <div class="split-screen__image-col">
        <img src="assets/images/<?= htmlspecialchars($book->getImage()) ?>" alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>" class="split-screen__image">
    </div>

    <div class="split-screen__content-col">
        <h1 class="book-detail__title"><?= htmlspecialchars($book->getTitle()) ?></h1>
        <p class="book-detail__author">par <?= htmlspecialchars($book->getAuthor()) ?></p>

        <hr class="book-detail__divider">

        <div class="book-detail__description">
            <p class="book-detail__label">Description</p>
            <?php foreach (explode("\n", $book->getDescription()) as $paragraph): ?>
                <p><?= htmlspecialchars($paragraph) ?></p>
            <?php endforeach; ?>
        </div>

        <div class="book-detail__owner">
            <p class="book-detail__label">Propriétaire</p>
            <a href="profil/<?= htmlspecialchars($owner->getId()) ?>" class="owner-card">
                <img src="<?= htmlspecialchars($owner->getAvatar()) ?>" alt="Avatar de <?= htmlspecialchars($owner->getUsername()) ?>" class="owner-card__avatar">
                <span class="owner-card__name"><?= htmlspecialchars($owner->getUsername()) ?></span>
            </a>
        </div>
        <a href="messagerie/nouveau/<?= htmlspecialchars($owner->getId()) ?>" class="button button--primary button--block">
            Envoyer un message
        </a>
    </div>
</section>