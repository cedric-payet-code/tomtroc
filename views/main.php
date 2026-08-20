<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'TomTroc') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header class="header">
        <div class="container header__inner">
            <a href="/" class="logo">
                <span class="logo__mark">Tt</span>
                <span class="logo__text">Tom Troc</span>
            </a>

            <nav class="nav-main">
                <a href="/" class="nav-main__link is-active">Accueil</a>
                <a href="/livres" class="nav-main__link">Nos livres à l'échange</a>
            </nav>

            <nav class="nav-secondary">
                <a href="/messagerie" class="nav-secondary__link">
                    Messagerie <span class="badge">1</span>
                </a>
                <a href="/compte" class="nav-secondary__link">Mon compte</a>
                <a href="/connexion" class="nav-secondary__link">Connexion</a>
            </nav>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer class="footer">
        <div class="container footer__inner">
            <a href="/politique-confidentialite">Politique de confidentialité</a>
            <a href="/mentions-legales">Mentions légales</a>
            <span>Tom Troc©</span>
            <span class="footer__logo">Tt</span>
        </div>
    </footer>

</body>
</html>
