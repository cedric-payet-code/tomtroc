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
}