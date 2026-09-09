<?php

class LivreController extends AbstractController
{
    public function livre(string $id): void
    {
        $bookManager = new BookManager();
        $bookWithUser = $bookManager->getBook($id);

        if (!$bookWithUser) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath);
            exit;
        }

        $this->render('livre/livre', [
            'title' => $bookWithUser['book']->getTitle(),
            'bookWithUser' => $bookWithUser
        ]);
    }

    public function livres(): void
    {
        $search = $_GET['q'] ?? '';

        $bookManager = new BookManager();

        $booksWithOwner = [];

        if ($search == '') {
            $booksWithOwner = $bookManager->getBooks();
        } else {
            $booksWithOwner = $bookManager->getBooksByTitle($search);
        }

        $this->render('livre/nos-livres', [
            'title' => 'Nos Livres',
            'search' => $search,
            'booksWithOwner' => $booksWithOwner,
        ]);
    }

    public function modification(string $id): void
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
            header('Location: ' . $basePath . 'mon-compte');
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

    public function suppression(string $id): void
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