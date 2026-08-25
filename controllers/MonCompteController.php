<?php

class MonCompteController extends AbstractController
{
    public function index(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /projet-4-option-b/connexion');
            exit;
        }

        $user = $_SESSION['user'];

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->handleSubmit();

            if (empty($errors)) {
                $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
                header('Location: ' . $basePath . 'mon-compte');
                exit;
            }
        }

        $bookManager = new BookManager();
        $userBooks = $bookManager->getBooksByOwnerId($user->getId());

        $created = new DateTime($user->getCreatedAt());
        $now = new DateTime();
        $interval = $created->diff($now);

        $memberSince = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');

        $this->render('mon-compte/index', [
            'title' => 'Mon Compte',
            'user' => $user,
            'books' => $userBooks,
            'memberSince' => $memberSince,
            'errors' => $errors,
        ]);
    }

    private function handleSubmit(): array
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = $this->validate($username, $email, $password);

        if (!empty($errors)) {
            return $errors;
        }

        $userManager = new UserManager();
        $user = $_SESSION['user'];

        $existingUser = $userManager->getUserByEmail($email);

        if ($existingUser && $existingUser->getId() != $user->getId()) {
            return ['Un compte existe déjà avec cette adresse email.'];
        }

        $existingUser = $userManager->getUserByUsername($username);

        if ($existingUser && $existingUser->getId() != $user->getId()) {
            return ['Ce pseudo est déjà utilisé.'];
        }

        if ($password === '') {
            $hashedPassword = $user->getPassword();
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);

        $userManager->updateUser($user);

        $_SESSION['user'] = $user;

        return [];
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

        if ($password !== '' && strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }

        return $errors;
    }
}