<?php

namespace App\Controllers;

use App\Managers\BookManager;
use App\Services\AbstractController;

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