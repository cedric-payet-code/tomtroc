<?php

class MessageController extends AbstractController
{
    public function message(?string $id = null): void
    {
        $messageManager = new MessageManager();
        $userManager = new UserManager();

        if (!isset($_SESSION['user']) || $id == $_SESSION['user']->getId()) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'mon-compte');
            exit;
        }

        $user = $_SESSION['user'];

        $activeContact = null;
        $activeMessages = [];
        
        if ($id) {
            $activeContact = $userManager->getUserById($id);

            if (!$activeContact) {
                $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
                header('Location: ' . $basePath . 'message');
                exit;
            }
        }

        $chats = $messageManager->getChats($user->getId());

        foreach ($chats as $index => $chat) {
            $chats[$index]['lastMessageAt'] =
                $this->getFormattedSentAt(
                    $chat['lastMessage']?->getSentAt()
                );

            if ($chat['user']->getId() == $id) {
                $messages = $messageManager->getMessages($chat['chat']->getId());
                
                foreach ($messages as $message) {
                    $sentAt = $this->getFormattedSentAt($message->getSentAt());

                    $activeMessages[] = [
                        'message' => $message,
                        'sentAt' => $sentAt,
                    ];
                }
            }
        }

        $this->render('message/message', [
            'title' => 'Messagerie',
            'activeChatId' => $id,
            'chats' => $chats,
            'activeMessages' => $activeMessages,
            'activeContact' => $activeContact,
        ]);
    }

    private function getFormattedSentAt(?string $sentAt): string
    {
        if (!$sentAt) {
            return "";
        }

        $formattedsentAt = "";
        $sent = new DateTime($sentAt);
        $now = new DateTime();

        if ($now->format('Y') != $sent->format('Y')) {
            $formattedsentAt = $sent->format('d.m.Y');
        } elseif ($now->format('d.m') == $sent->format('d.m')) {
            $formattedsentAt = $sent->format('H:i');
        } else {
            $formattedsentAt = $sent->format('d.m');
        }

        return $formattedsentAt;
    }

    public function nouveau(string $id): void
    {
        $messageManager = new MessageManager();
        // $userManager = new UserManager();
        
        $user1Id = null;
        $user2Id = null;

        if (!isset($_SESSION['user']) || $id == $_SESSION['user']->getId()) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'mon-compte');
            exit;
        }

        // if (!$userManager->getUserById($id)) {
        //     $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        //     header('Location: ' . $basePath . 'compte');
        //     exit;
        // }


        if ($id < $_SESSION['user']->getId()) {
            $user1Id = $id;
            $user2Id = $_SESSION['user']->getId();
        } else {
            $user1Id = $_SESSION['user']->getId();
            $user2Id = $id;
        }

        $chat = $messageManager->getChat($user1Id, $user2Id);

        if ($chat) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
            header('Location: ' . $basePath . 'message/' . $chat->getId());
            exit;
        }

        $chatId = $messageManager->createChat($user1Id, $user2Id);

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        header('Location: ' . $basePath . 'message/' . $chatId);
        exit;
    }
}