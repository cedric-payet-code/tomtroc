<section class="hero container">
    <div class="hero__text">
        <h1 class="hero__title">Rejoignez nos lecteurs passionnés</h1>
        <p class="hero__description">
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la
            lecture. Nous croyons en la magie du partage de connaissances et d'histoires à
            travers les livres.
        </p>
        <a href="/livres" class="button button--primary">Découvrir</a>
    </div>

    <figure class="hero__figure">
        <img src="assets/images/hero.jpg" alt="Un lecteur assis parmi des piles de livres, dans l'embrasure d'une porte." class="hero__image">
        <figcaption class="hero__credit">Hamza</figcaption>
    </figure>
</section>

<section class="latest-books">
    <div class="container">
        <h2 class="section-title">Les derniers livres ajoutés</h2>

        <div class="book-grid">
            <?php foreach ($latestBooks as $book): ?>
                <article class="book-card">

                    <img
                        src="assets/images/<?= htmlspecialchars($book->getImage() ?? '') ?>"
                        alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>"
                        class="book-card__image"
                    >

                    <h3 class="book-card__title">
                        <?= htmlspecialchars($book->getTitle()) ?>
                    </h3>

                    <p class="book-card__author">
                        <?= htmlspecialchars($book->getAuthor()) ?>
                    </p>

                    <p class="book-card__seller">
                        Vendu par : seller_id
                    </p>

                </article>
            <?php endforeach; ?>
        </div>

        <div class="latest-books__cta">
            <a href="/livres" class="button button--primary">Voir tous les livres</a>
        </div>
    </div>
</section>

<section class="how-it-works">
    <div class="container">
        <h2 class="section-title">Comment ça marche ?</h2>
        <p class="how-it-works__intro">
            Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :
        </p>

        <div class="step-grid">
            <div class="step-card">Inscrivez-vous gratuitement sur notre plateforme.</div>
            <div class="step-card">Ajoutez les livres que vous souhaitez échanger à votre profil.</div>
            <div class="step-card">Parcourez les livres disponibles chez d'autres membres.</div>
            <div class="step-card">Proposez un échange et discutez avec d'autres passionnés de lecture.</div>
        </div>

        <a href="/livres" class="button button--outline">Voir tous les livres</a>
    </div>
</section>

<img src="assets/images/bibliotheque.jpg" alt="Bibliothèque garnie de livres, ambiance chaleureuse." class="divider-image">

<section class="values container">
    <h2 class="values__title">Nos valeurs</h2>

    <div class="values__content">
        <p>
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté.
            Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer
            des liens entre les lecteurs. Nous croyons en la puissance des histoires pour
            rassembler les gens et inspirer des conversations enrichissantes.
        </p>
        <p>
            Notre association a été fondée avec une conviction profonde : chaque livre mérite
            d'être lu et partagé.
        </p>
        <p>
            Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux
            lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des
            livres qui attendent patiemment sur les étagères.
        </p>

        <p class="values__signature">L'équipe Tom Troc</p>

        <svg class="values__doodle" width="120" height="102" viewBox="0 0 122 104" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 96.2239C2.29696 95.8231 6.2879 96.4857 7.64535 96.4799C34.2391 96.3671 77.2911 74.6938 96.4064 56.0077C109.127 40.7678 119.928 7.80676 85.8057 2.24498C65.0283 -1.14163 50.1873 26.798 62.0601 33.1479C66.0177 35.2646 78.258 25.6127 65.0283 12.4049C51.7986 -0.802991 39.7279 0.128338 35.3463 2.24498C15.417 7.74826 2.27208 42.7152 71.8127 87.7573C96.4064 103.687 121 102.997 121 102.997"
                    stroke="#00AC66" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>
</section>
