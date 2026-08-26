<?php

class LivreController extends AbstractController
{
    public function index(string $id): void
    {
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            // livre introuvable, à gérer (404 ou redirection)
        }

        $userManager = new UserManager();
        $owner = $userManager->getUserById($book->getOwnerId());

        if (!$owner) {
            // utilisateur introuvable, à gérer (404 ou redirection) ???
        }

        $this->render('livre/index', [
            'title' => $book->getTitle(),
            'book' => $book,
            'owner' => $owner,
        ]);
    }

    public function update(string $id): void
    {
        if (!isset($_SESSION['user'])) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'connexion');
            exit;
        }

        $user = $_SESSION['user'];

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book || $book->getOwnerId() != $user->getId()) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'compte');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmit($book);
            return;
        }

        $this->render('livre/modification', [
            'title' => $book->getTitle(),
            'book' => $book,
        ]);
    }

    private function handleSubmit(Book $book): void
    {
        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $available = ($_POST['available'] ?? '1') === '1';

        $errors = [];

        if ($title === '') {
            $errors[] = 'Le titre est obligatoire.';
        }

        if ($author === '') {
            $errors[] = "L'auteur est obligatoire.";
        }

        if (!empty($errors)) {
            $this->render('livre/modification', [
                'title' => $book->getTitle(),
                'book' => $book,
                'errors' => $errors,
            ]);
            return;
        }

        $imageName = $book->getImage();

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('book_') . '.' . $extension;
            $destination = dirname(__DIR__) . '/assets/images/' . $imageName;
            move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
        }

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $book->setAvailable($available);
        $book->setImage($imageName);

        $bookManager = new BookManager();
        $bookManager->updateBook($book);

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        header('Location: ' . $basePath . 'livre/' . $book->getId() . '/update');
        exit;
    }

    public function delete(string $id): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /projet-4-option-b/connexion');
            exit;
        }

        $bookManager = new BookManager();

        $bookManager->deleteBook(
            $id,
            $_SESSION['user']->getId()
        );

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        header('Location: ' . $basePath . 'mon-compte');
        exit;
    }
}