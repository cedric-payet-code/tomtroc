<?php

class NosLivresController extends AbstractController
{
    public function index(): void
    {
        $search = $_GET['q'] ?? '';

        $bookManager = new BookManager();
        $books = [];

        if ($search == '') {
            $books = $bookManager->getAllBooks();
        } else {
            $books = $bookManager->getAllBooksByTitle($search);
        }

        $booksWithOwner = [];

        $userManager = new UserManager();

        foreach ($books as $book) {
            $owner = $userManager->getUserById($book->getOwnerId());

            $booksWithOwner[] = [
                'book' => $book,
                'owner' => $owner,
            ];
        }

        $this->render('nos-livres/index', [
            'title' => 'Nos Livres',
            'search' => $search,
            'booksWithOwner' => $booksWithOwner,
        ]);
    }
}