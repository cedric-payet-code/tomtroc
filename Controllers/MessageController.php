<?php

namespace App\Controllers;

use App\Managers\MessageManager;
use App\Managers\UserManager;
use App\Services\AbstractController;
use DateTime;

class MessageController extends AbstractController
{
    public function message(?string $id = null): void
    {
        $messageManager = new MessageManager();
        $userManager = new UserManager();

        if (!isset($_SESSION['user']) || $id == $_SESSION['user']->getId()) {
            header('Location: /mon-compte');
            exit;
        }

        $user = $_SESSION['user'];

        $activeContact = null;
        $activeChat = null;
        $activeMessages = [];
        
        if ($id) {
            $activeContact = $userManager->getUserById($id);

            if (!$activeContact) {
                header('Location: /messages');
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
                $activeChat = $chat['chat'];
                $messages = $messageManager->getMessages($chat['chat']->getId());
                $messageManager->setMessagesAsSeen($chat['chat']->getId(), $id);
                
                foreach ($messages as $message) {
                    $sentAt = $this->getFormattedSentAt($message->getSentAt());

                    $activeMessages[] = [
                        'message' => $message,
                        'sentAt' => $sentAt,
                    ];
                }
            }
        }

        // Pas encore de conversation avec ce contact : on passe par "nouveau" qui la crée.
        if ($activeContact && !$activeChat) {
            header('Location: /message/' . $id . '/nouveau');
            exit;
        }

        $this->render('message/message', [
            'title' => 'Messagerie',
            'chats' => $chats,
            'activeMessages' => $activeMessages,
            'activeContact' => $activeContact,
            'activeChat' => $activeChat,
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

        if ($now->format('d.m.Y') == $sent->format('d.m.Y')) {
            $formattedsentAt = $sent->format('H:i');
        } elseif ($now->format('Y') == $sent->format('Y')) {
            $formattedsentAt = $sent->format('d.m H:i');
        } else {
            $formattedsentAt = $sent->format('d.m.Y H:i');
        }

        return $formattedsentAt;
    }

    public function nouveau(string $id): void
    {
        $messageManager = new MessageManager();
        $userManager = new UserManager();

        $user1Id = null;
        $user2Id = null;

        if (!isset($_SESSION['user']) || $id == $_SESSION['user']->getId()) {
            header('Location: /mon-compte');
            exit;
        }

        // On ne crée pas de conversation avec un utilisateur inexistant.
        if (!$userManager->getUserById($id)) {
            header('Location: /messages');
            exit;
        }

        if ($id < $_SESSION['user']->getId()) {
            $user1Id = $id;
            $user2Id = $_SESSION['user']->getId();
        } else {
            $user1Id = $_SESSION['user']->getId();
            $user2Id = $id;
        }

        // Crée la conversation seulement si elle n'existe pas encore.
        if (!$messageManager->getChat($user1Id, $user2Id)) {
            $messageManager->addChat($user1Id, $user2Id);
        }

        // La route message/{id} attend l'id du contact, pas celui de la conversation.
        header('Location: /message/' . $id);
        exit;
    }

    public function envoyer(string $id): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /connexion');
            exit;
        }

        $messageManager = new MessageManager();
        $chat = $messageManager->getChatById($id);

        $user = $_SESSION['user'];

        if (!$chat) {
            header('Location: /messages');
            exit;
        }

        $message = trim($_POST['message'] ?? '');

        if ($message !== '') {
            $messageManager->addMessage((int) $id, $user->getId(), $message);
        }

        $idRedirection =  $user->getId() == $chat->getUser1Id() ? $chat->getUser2Id() : $chat->getUser1Id();
        
        header('Location: /message/' . $idRedirection);
        exit;
    }
}