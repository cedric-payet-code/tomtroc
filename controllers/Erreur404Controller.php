<?php

namespace App\Controllers;

use App\Services\AbstractController;

class Erreur404Controller extends AbstractController
{
    public function show(): void
    {
        http_response_code(404);

        $this->render('erreur404/erreur404', [
            'title' => 'Page introuvable - TomTroc',
        ]);
    }
}