<?php

namespace App\Services;

use App\Managers\MessageManager;

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

    protected function deleteUploadedImage(?string $imageName, string $prefix): void
    {
        if ($imageName === null || !str_starts_with($imageName, $prefix)) {
            return;
        }

        $path = dirname(__DIR__) . '/assets/images/' . basename($imageName);

        if (is_file($path)) {
            unlink($path);
        }
    }
}

