<?php

class AccueilController extends AbstractController
{
    public function accueil(): void
    {
        $bookManager = new BookManager();

        $latestBooks = $bookManager->getLatestBooks();

        $this->render('accueil/accueil', [
            'title' => 'Accueil',
            'latestBooks' => $latestBooks,
        ]);
    }
}