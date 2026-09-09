<?php

class AuthentificationController extends AbstractController
{
    public function inscription(): void
    {
        if (isset($_SESSION['user'])) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'mon-compte');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmitInscription();
            return;
        }

        $this->render('authentification/inscription', [
            'title' => 'Inscription',
        ]);
    }

    private function handleSubmitInscription(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = $this->validate($username, $email, $password);

        if (!empty($errors)) {
            $this->render('authentification/inscription', [
                'title' => 'Inscription',
                'errors' => $errors,
                'username' => $username,
                'email' => $email,
            ]);
            return;
        }

        $userManager = new UserManager();

        if ($userManager->getUserByEmail($email)) {
            $this->render('authentification/inscription', [
                'title' => 'Inscription',
                'errors' => ['Un compte existe déjà avec cette adresse email.'],
                'username' => $username,
                'email' => $email,
            ]);
            return;
        }

        if ($userManager->getUserByUsername($username)) {
            $this->render('authentification/inscription', [
                'title' => 'Inscription',
                'errors' => ['Ce pseudo est déjà utilisé.'],
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

    public function connexion(): void
    {
        if (isset($_SESSION['user'])) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'mon-compte');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmitConnexion();
            return;
        }

        $this->render('authentification/connexion', [
            'title' => 'Connexion',
        ]);
    }

    private function handleSubmitConnexion(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            $this->render('authentification/connexion', [
                'title' => 'Connexion',
                'errors' => ['Email ou mot de passe incorrect.'],
                'email' => $email,
            ]);
            return;
        }

        $_SESSION['user'] = $user;

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        header('Location: ' . $basePath);
        exit;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: /projet-4-option-b/');
        exit;
    }
}