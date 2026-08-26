<?php

class ConnexionController extends AbstractController
{
    public function index(): void
    {
        if (isset($_SESSION['user'])) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'mon-compte');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmit();
            return;
        }

        $this->render('connexion/index', [
            'title' => 'Connexion',
        ]);
    }

    private function handleSubmit(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            $this->render('connexion/index', [
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