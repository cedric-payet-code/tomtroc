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
        if (!$_SESSION['user']) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: /projet-4-option-b/connexion');
            exit;
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if ($book->getOwnerId() != $id) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'mon-compte');
            exit;
        }

        $this->render('livre/modification', [
            'title' => $book->getTitle(),
            'book' => $book,
            'owner' => $owner,
        ]);
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