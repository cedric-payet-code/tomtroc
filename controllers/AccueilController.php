<?php

class AccueilController extends AbstractController
{
    public function index(): void
    {
        $this->render('accueil/index', [
            'title' => 'Accueil - TomTroc',
            'message' => 'Hello World, en MVC !',
        ]);
    }
}