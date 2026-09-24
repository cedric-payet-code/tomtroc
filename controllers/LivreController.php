<?php

namespace App\Controllers;

use App\Managers\BookManager;
use App\Models\Book;
use App\Services\AbstractController;

class LivreController extends AbstractController
{
    public function livre(string $id): void
    {
        $bookManager = new BookManager();
        $bookWithUser = $bookManager->getBook($id);

        if (!$bookWithUser) {
            header('Location: /accueil');
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
            header('Location: /connexion');
            exit;
        }

        $user = $_SESSION['user'];

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book || $book->getOwnerId() != $user->getId()) {
            header('Location: /mon-compte');
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
            $newImageName = uniqid('book_') . '.' . $extension;
            $destination = dirname(__DIR__) . '/assets/images/' . $newImageName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                $this->deleteUploadedImage($imageName, 'book_');
                $imageName = $newImageName;
            }
        }

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $book->setAvailable($available);
        $book->setImage($imageName);

        $bookManager = new BookManager();
        $bookManager->updateBook($book);

        header('Location: /livre/' . $book->getId());
        exit;
    }

    public function suppression(string $id): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /connexion');
            exit;
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        // Seul le propriétaire peut supprimer le livre (et donc son image).
        if (!$book || $book->getOwnerId() != $_SESSION['user']->getId()) {
            header('Location: /mon-compte');
            exit;
        }

        $bookManager->deleteBook(
            $id,
            $_SESSION['user']->getId()
        );

        $this->deleteUploadedImage($book->getImage(), 'book_');

        header('Location: /mon-compte');
        exit;
    }

    public function ajouter(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleCreate();
            return;
        }

        $this->render('livre/ajouter', [
            'title' => 'Ajouter un livre',
        ]);
    }

    private function handleCreate(): void
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
            $this->render('livre/ajouter', [
                'title' => 'Ajouter un livre',
                'errors' => $errors,
            ]);
            return;
        }

        $imageName = 'livre.jpg';

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('book_') . '.' . $extension;
            $destination = dirname(__DIR__) . '/assets/images/' . $imageName;
            move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
        }

        $book = new Book();
        $book->setOwnerId($_SESSION['user']->getId());
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $book->setAvailable($available);
        $book->setImage($imageName);

        $bookManager = new BookManager();
        $newBookId = $bookManager->createBook($book);

        header('Location: /livre/' . $newBookId);
        exit;
    }
}