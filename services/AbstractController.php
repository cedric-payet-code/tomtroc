<?php

abstract class AbstractController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        if (isset($_SESSION['user'])) {
            $messageManager = new MessageManager();
            $unreadMessages = $messageManager->countUnreadMessages($_SESSION['user']->getId());
        } else {
            $unreadMessagesCount = null;
        }

        $viewFile = dirname(__DIR__) . '/views/' . $view . '.php';

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require dirname(__DIR__) . '/views/main.php';
    }
}

