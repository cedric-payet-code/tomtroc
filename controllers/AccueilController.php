<?php

class AccueilController extends AbstractController
{
    public function index(): void
    {
        $bookManager = new BookManager();

        $latestBooks = $bookManager->getLatestBooks();

        $this->render('accueil/index', [
            'title' => 'Accueil',
            'latestBooks' => $latestBooks,
        ]);
    }
}