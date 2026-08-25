<?php

class AccueilController extends AbstractController
{
    public function index(): void
    {
        $bookManager = new BookManager();

        $latestBooks = $bookManager->getLatestBooks();

        $latestBooksWithOwner = [];

        $userManager = new UserManager();

        foreach ($latestBooks as $book) {
            $owner = $userManager->getUserById($book->getOwnerId());

            $latestBooksWithOwner[] = [
                'book' => $book,
                'owner' => $owner,
            ];
        }

        $this->render('accueil/index', [
            'title' => 'Accueil',
            'latestBooksWithOwner' => $latestBooksWithOwner,
        ]);
    }
}