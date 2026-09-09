<?php

class MessageManager extends AbstractManager
{
    public function createChat(string $user1Id, string $user2Id): int
    {
        $sql = "INSERT INTO chats (user1_id, user2_id)
                VALUES (:user1_id, :user2_id)";

        $query = $this->db->getPDO()->prepare($sql);

        $query->execute([
            'user1_id' => $user1Id,
            'user2_id' => $user2Id,
        ]);

        return (int) $this->db->getPDO()->lastInsertId();
    }

    public function getChat(string $user1Id, string $user2Id): ?Chat
    {
        $sql = "SELECT *
                FROM chats
                WHERE user1_id = :user1_id
                AND user2_id = :user2_id";

        $query = $this->db->getPDO()->prepare($sql);

        $query->execute([
            'user1_id' => $user1Id,
            'user2_id' => $user2Id,
        ]);

        $data = $query->fetch();

        if (!$data) {
            return null;
        }

        return new Chat($data);
    }

    public function getChats(string $userId): array
    {
        $sql = "SELECT chats.*,
                    users.id AS user_id,
                    users.username,
                    users.avatar,
                    messages.message,
                    messages.sent_at
                FROM chats

                JOIN users ON users.id = CASE
                    WHEN chats.user1_id = :user_id_case
                    THEN chats.user2_id
                    ELSE chats.user1_id
                END

                LEFT JOIN messages ON messages.id = (
                    SELECT MAX(m.id)
                    FROM messages m
                    WHERE m.chat_id = chats.id
                )

                WHERE chats.user1_id = :user_id_1
                OR chats.user2_id = :user_id_2

                ORDER BY chats.id DESC";

        $query = $this->db->getPDO()->prepare($sql);

        $query->execute([
            'user_id_case' => $userId,
            'user_id_1' => $userId,
            'user_id_2' => $userId,
        ]);

        $chats = [];

        while ($data = $query->fetch()) {
            $chat = new Chat($data);

            $user = new User();
            $user->setId($data['user_id']);
            $user->setUsername($data['username']);
            $user->setAvatar($data['avatar']);

            $lastMessage = null;

            if ($data['message'] !== null) {
                $lastMessage = new Message();

                $lastMessage->setMessage($data['message']);
                $lastMessage->setSentAt($data['sent_at']);
            }

            $chats[] = [
                'chat' => $chat,
                'user' => $user,
                'lastMessage' => $lastMessage,
            ];
        }

        return $chats;
    }

    public function getMessages(string $chatId): array
    {
        $sql = "SELECT *
                FROM messages
                WHERE chat_id = :chat_id
                ORDER BY id ASC";

        $query = $this->db->getPDO()->prepare($sql);

        $query->execute([
            'chat_id' => $chatId,
        ]);

        $messages = [];

        while ($data = $query->fetch()) {
            $messages[] = new Message($data);
        }

        return $messages;
    }

    public function getLastMessageByChatId(string $chatId): ?Message
    {
        $sql = "SELECT *
                FROM messages
                WHERE chat_id = :chat_id
                ORDER BY id DESC
                LIMIT 1";

        $query = $this->db->getPDO()->prepare($sql);

        $query->execute([
            'chat_id' => $chatId,
        ]);

        $data = $query->fetch();

        if (!$data) {
            return null;
        }

        return new Message($data);
    }
}