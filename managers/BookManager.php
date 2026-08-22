<?php

class BookManager extends AbstractManager
{
    public function getLatestBooks(): array
    {
        $sql = "SELECT *
                FROM books
                ORDER BY id DESC
                LIMIT 4";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute();

        $latestBooks = [];

        while ($data = $query->fetch()) {
            $latestBooks[] = new Book($data);
        }

        return $latestBooks;
    }
}