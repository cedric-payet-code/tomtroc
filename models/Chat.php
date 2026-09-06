<?php

class Chat extends AbstractEntity
{
    private int $user1Id;
    private int $user2Id;

    /**
     * Getter pour le user1.
     *
     * @return int
     */
    public function getUser1Id(): int
    {
        return $this->user1Id;
    }

    /**
     * Setter pour le user1.
     *
     * @param int $user1
     * @return void
     */
    public function setUser1Id(int $user1Id): void
    {
        $this->user1Id = $user1Id;
    }

    /**
     * Getter pour le user2.
     *
     * @return int
     */
    public function getUser2Id(): int
    {
        return $this->user2Id;
    }

    /**
     * Setter pour le user2.
     *
     * @param int $user2
     * @return void
     */
    public function setUser2Id(int $user2Id): void
    {
        $this->user2Id = $user2Id;
    }

}