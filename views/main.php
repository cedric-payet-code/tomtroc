<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'TomTroc') ?></title>
</head>
<body>
    <header><h1>TomTroc</h1></header>
    <main><?= $content ?></main>
</body>
</html>