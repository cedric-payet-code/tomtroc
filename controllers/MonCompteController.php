<?php

class MonCompteController extends AbstractController
{
    public function index(): void
    {
        if (!$_SESSION['user']) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: /projet-4-option-b/connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmit();
            return;
        }
        
        $user = $_SESSION['user'];

        $bookManager = new BookManager();

        $created = new DateTime($user->getCreatedAt());
        $now = new DateTime();
        $interval = $created->diff($now);
        $memberSince = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');

        $userBooks = $bookManager->getBooksByOwnerId($user->getId());

        $this->render('mon-compte/index', [
            'title' => 'Mon Compte',
            'user' => $_SESSION['user'],
            'books' => $userBooks,
            'memberSince' => $memberSince,
        ]);
    }

    private function handleSubmit(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
 
        $errors = [];
 
        if ($username === '') {
            $errors[] = 'Le pseudo est obligatoire.';
        }
 
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'adresse email n\'est pas valide.';
        }
 
        $userManager = new UserManager();
        $user = $_SESSION['user'];

        $existingUser = $userManager->getUserByEmail($email);
        if ($existingUser && $existingUser->getId() !== $user->getId()) {
            $errors[] = 'Un autre compte utilise déjà cette adresse email.';
        }
 
        if (!empty($errors)) {
            $this->showAccountPage($errors);
            return;
        }
 
        $user->setUsername($username);
        $user->setEmail($email);

        if ($password !== '') {
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        }
 
        $userManager->updateUser($user);
 

        $_SESSION['user'] = $user;
 
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        header('Location: ' . $basePath . 'mon-compte');
        exit;
    }
}