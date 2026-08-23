<section class="split-screen">
    <div class="split-screen__content-col">
        <h1 class="auth__title">Connexion</h1>

        <?php if (!empty($errors)): ?>
            <div class="auth__errors">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="auth__form" action="connexion" method="post">
            <div class="form-field">
                <label for="email" class="form-field__label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-field__input" value="<?= htmlspecialchars($email ?? '') ?>" required>
            </div>

            <div class="form-field">
                <label for="password" class="form-field__label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-field__input" required>
            </div>

            <button type="submit" class="button button--primary button--block auth__submit">
                Se connecter
            </button>
        </form>

        <p class="auth__footer-text">
            Pas de compte ? <a href="inscription">Inscrivez-vous</a>
        </p>
    </div>

    <div class="split-screen__image-col">
        <img src="assets/images/bibliotheque-inscription.png" alt="Étagère de bibliothèque garnie de livres" class="split-screen__image">
    </div>
</section>