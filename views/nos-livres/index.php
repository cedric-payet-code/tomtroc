<section class="container">
    <div class="livres-header">
        <h1 class="livres-header__title">Nos livres à l'échange</h1>

        <form class="search-field" action="nos-livres" method="get">
            <svg class="search-field__icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.5"/>
                <path d="M17 17L13 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <input
                type="text"
                name="q"
                class="search-field__input"
                placeholder="Rechercher un livre"
                value="<?= htmlspecialchars($search ?? '') ?>"
            >
        </form>
    </div>

    <div class="livres-grid-wrapper">
        <div class="book-grid">
            <?php foreach ($books as $book): ?>
                <article class="book-card">
                    <?php if (!$book->isAvailable()): ?>
                        <span class="book-card__badge">non dispo.</span>
                    <?php endif; ?>

                    <img
                        src="assets/images/<?= htmlspecialchars($book->getImage() ?? '') ?>"
                        alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>"
                        class="book-card__image"
                    >

                    <h3 class="book-card__title"><?= htmlspecialchars($book->getTitle()) ?></h3>
                    <p class="book-card__author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                    <p class="book-card__seller">Vendu par : seller_id</p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>