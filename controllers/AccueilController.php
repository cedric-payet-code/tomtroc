<?php

class AccueilController extends AbstractController
{
    public function index(): void
    {
        $this->render('accueil/index', [
            'title' => 'Accueil',
        ]);
    }
}