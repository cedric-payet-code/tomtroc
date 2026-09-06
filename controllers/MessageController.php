<?php

class MessageController extends AbstractController
{
    public function index(string $id): void
    {
        $chatManager = new ChatManager();
        $userManager = new UserManager();

        $chats = $chatManager->getAllChats();

        $chatsWithUser = [];
        $activeContact = null;

        foreach ($chats as $chat) {
            if ($chat->getUser1Id() == $_SESSION['user']->getId()) {
                $user = $userManager->getUserById($chat->getUser2Id());
            } else {
                $user = $userManager->getUserById($chat->getUser1Id());
            }

            $lastMessage = $chatManager->getLastMessageByChatId($chat->getId());

            $chatsWithUser[] = [
                'chat' => $chat,
                'user' => $user,
                'lastMessageAt' => $this->getFormattedSentAt($lastMessage->getSentAt()),
                'lastMessage' => $lastMessage,
            ];
            
            if ($chat->getId() == $id) {
                $activeContact = $user;
            }
        }

        $activeChatMessages = $chatManager->getAllMessagesByChatId($id);

        $this->render('message/index', [
            'title' => 'Messagerie',
            'chatsWithUser' => $chatsWithUser,
            'activeChatId' => $id,
            'activeContact' => $activeContact,
            'activeChatMessages' => $activeChatMessages,
            'currentUser' => $_SESSION['user'],
        ]);
    }

    private function getFormattedSentAt(string $sentAt): string
    {
        $formattedsentAt = null;
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
}