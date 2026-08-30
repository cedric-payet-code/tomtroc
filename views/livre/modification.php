<div class="container modification-container">
    <a href="mon-compte" class="edit-book__back-link">&larr; retour</a>
    <h1 class="page-title">Modifier les informations</h1>

    <div class="card">
        <form action="livre/<?= htmlspecialchars($book->getId()) ?>/update" method="post" enctype="multipart/form-data" class="edit-book__grid">

            <div class="edit-book__photo-col">
                <p class="form-field__label">Photo</p>
                <img src="assets/images/<?= htmlspecialchars($book->getImage() ?? 'livre.jpg') ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>" class="edit-book__photo">
                <label for="photo" class="edit-book__photo-link" style="cursor: pointer;">Modifier la photo</label>
                <input type="file" name="photo" id="photo" accept="image/*" style="display: none;">
            </div>

            <div class="edit-book__form-col">
                <div class="form-field">
                    <label for="title" class="form-field__label">Titre</label>
                    <input type="text" name="title" id="title" class="form-field__input" value="<?= htmlspecialchars($book->getTitle()) ?>" required>
                </div>

                <div class="form-field">
                    <label for="author" class="form-field__label">Auteur</label>
                    <input type="text" name="author" id="author" class="form-field__input" value="<?= htmlspecialchars($book->getAuthor()) ?>" required>
                </div>

                <div class="form-field">
                    <label for="description" class="form-field__label">Commentaire</label>
                    <textarea name="description" id="description" class="form-field__textarea"><?= htmlspecialchars($book->getDescription()) ?></textarea>
                </div>

                <div class="form-field">
                    <label for="available" class="form-field__label">Disponibilité</label>
                    <select name="available" id="available" class="form-field__select">
                        <option value="1" <?= $book->isAvailable() ? 'selected' : '' ?>>disponible</option>
                        <option value="0" <?= !$book->isAvailable() ? 'selected' : '' ?>>non disponible</option>
                    </select>
                </div>

                <button type="submit" class="button button--primary button--block">Valider</button>
            </div>
        </form>
    </div>
</div>