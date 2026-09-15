<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'; ?>
    <base href="<?= htmlspecialchars($basePath) ?>">
    <title><?= htmlspecialchars($title ?? 'TomTroc') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<?php
    $currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $currentPath = str_replace(trim($basePath, '/'), '', $currentPath);
    $currentPath = trim($currentPath, '/');

    function isCurrentPage(string $currentPath, string $route): string
    {
        $route = trim($route, '/');

        return $currentPath === $route || str_starts_with($currentPath, $route . '/')
            ? ' is-active'
            : '';
    }
?>

<body>

    <header class="header">
        <div class="container header__inner">
            <a href="accueil" class="logo">
                <img class="header__logo" src="assets/images/header-logo.png">
            </a>
            <nav class="nav">
                <nav class="nav-main">
                    <a href="accueil" class="nav-main__link<?= isCurrentPage($currentPath, '') || isCurrentPage($currentPath, 'accueil') ? ' is-active' : '' ?>">
                        Accueil
                    </a>
                    <a href="nos-livres" class="nav-main__link<?= isCurrentPage($currentPath, 'nos-livres') ?>">Nos livres à l'échange</a>
                </nav>

                <nav class="nav-secondary">
                    <a href="messages" class="nav-secondary__link<?= isCurrentPage($currentPath, 'messages') || isCurrentPage($currentPath, 'message') ? ' is-active' : '' ?>">
                        <img src="assets/images/icone-messagerie.svg">
                        Messagerie
                        <?php if (isset($unreadMessages) && $unreadMessages > 0): ?>
                            <span class="badge">
                                <?= $unreadMessages > 99 ? '99+' : htmlspecialchars($unreadMessages) ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <a href="mon-compte" class="nav-secondary__link<?= isCurrentPage($currentPath, 'mon-compte') ?>">Mon compte</a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="deconnexion" class="nav-secondary__link">Déconnexion</a>
                    <?php else: ?>
                        <a href="connexion" class="nav-secondary__link<?= isCurrentPage($currentPath, 'connexion') ?>">
                            <?= isset($_SESSION['user']) ? "Déconnexion" : "Connexion" ?>
                        </a>
                    <?php endif; ?>
                </nav>
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
            <a href="accueil" class="logo">
                <img class="footer__logo" src="assets/images/footer-logo.png">
            </a>
        </div>
    </footer>

</body>
</html>
