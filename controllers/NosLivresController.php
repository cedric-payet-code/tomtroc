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

        $this->render('nos-livres/index', [
            'title' => 'Nos Livres',
            'search' => $search,
            'books' => $books,
        ]);
    }
}