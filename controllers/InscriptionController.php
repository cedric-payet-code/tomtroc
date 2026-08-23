<?php

class InscriptionController extends AbstractController
{
    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmit();
            return;
        }

        $this->render('inscription/index', [
            'title' => 'Inscription',
        ]);
    }

    private function handleSubmit(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = $this->validate($username, $email, $password);

        if (!empty($errors)) {
            $this->render('inscription/index', [
                'title' => 'Inscription - TomTroc',
                'errors' => $errors,
                'username' => $username,
                'email' => $email,
            ]);
            return;
        }

        $userManager = new UserManager();

        if ($userManager->getUserByEmail($email)) {
            $this->render('inscription/index', [
                'title' => 'Inscription - TomTroc',
                'errors' => ['Un compte existe déjà avec cette adresse email.'],
                'username' => $username,
                'email' => $email,
            ]);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);

        $userManager->createUser($user);

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        header('Location: ' . $basePath . 'connexion');
        exit;
    }

    private function validate(string $username, string $email, string $password): array
    {
        $errors = [];

        if ($username === '') {
            $errors[] = 'Le pseudo est obligatoire.';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'adresse email n\'est pas valide.';
        }

        if (strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }

        return $errors;
    }
}