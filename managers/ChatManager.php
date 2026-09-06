<?php

class ChatManager extends AbstractManager
{

    public function getAllChats(): array
    {
        $sql = "SELECT *
                FROM chats";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute();

        $chats = [];

        while ($data = $query->fetch()) {
            $chats[] = new Chat($data);
        }

        return $chats;
    }

    public function getLastMessageByChatId(string $chatId): Message
    {
        $sql = "SELECT *
                FROM messages
                WHERE chat_id = :chat_id
                ORDER BY id DESC
                LIMIT 1";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['chat_id' => $chatId]);
        $data = $query->fetch();

        $chat = new Message($data);

        return $chat;
    }

    public function getAllMessagesByChatId(string $chatId): array
    {
        $sql = "SELECT *
                FROM messages
                WHERE chat_id = :chat_id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['chat_id' => $chatId]);

        $messages = [];

        while ($data = $query->fetch()) {
            $messages[] = new Message($data);
        }

        return $messages;
    }

}