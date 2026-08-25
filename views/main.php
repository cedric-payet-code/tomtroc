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
        return $currentPath === trim($route, '/') ? ' is-active' : '';
    }
?>

<body>

    <header class="header">
        <div class="container header__inner">
            <a href="accueil" class="logo">
                <span class="logo__mark">Tt</span>
                <span class="logo__text">Tom Troc</span>
            </a>

            <nav class="nav-main">
                <a href="accueil" class="nav-main__link<?= isCurrentPage($currentPath, '') || isCurrentPage($currentPath, 'accueil') ? ' is-active' : '' ?>">
                    Accueil
                </a>
                <a href="nos-livres" class="nav-main__link<?= isCurrentPage($currentPath, 'nos-livres') ?>">Nos livres à l'échange</a>
            </nav>

            <nav class="nav-secondary">
                <a href="/messagerie" class="nav-secondary__link">
                    Messagerie <span class="badge">1</span>
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
