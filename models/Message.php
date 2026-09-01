<?php

class Message extends AbstractEntity
{
    private int $chatId;
    private int $senderId;
    private string $message;
    private ?string $sentAt = null;

    /**
     * Getter pour le chatId.
     *
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * Setter pour le chatId.
     *
     * @param int $user1
     * @return void
     */
    public function setChatId(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    /**
     * Getter pour le senderId.
     *
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->senderId;
    }

    /**
     * Setter pour le senderId.
     *
     * @param int $user2
     * @return void
     */
    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    /**
     * Getter pour le message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Setter pour le lastMessageAt.
     *
     * @param int $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Getter pour le sentAt.
     *
     * @return ?string
     */
    public function getSentAt(): ?string
    {
        return $this->sentAt;
    }

    /**
     * Setter pour le sentAt.
     *
     * @param int $sentAt
     * @return void
     */
    public function setSentAt(string $sentAt): void
    {
        $this->sentAt = $sentAt;
    }

}