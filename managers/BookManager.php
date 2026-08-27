<?php

class BookManager extends AbstractManager
{
    public function getLatestBooks(): array
    {
        $sql = "SELECT *
                FROM books
                WHERE available = 1
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

    public function getAllBooks(): array
    {
        $sql = "SELECT *
                FROM books";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute();

        $availableBooks = [];

        while ($data = $query->fetch()) {
            $availableBooks[] = new Book($data);
        }

        return $availableBooks;
    }

    public function getAllBooksByTitle(string $search): array
    {
        $sql = "SELECT *
                FROM books
                WHERE title LIKE :search";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['search' => '%' . $search . '%']);

        $books = [];

        while ($data = $query->fetch()) {
            $books[] = new Book($data);
        }

        return $books;
    }

    public function getBookById(string $id): ?Book
    {
        $sql = "SELECT *
                FROM books
                WHERE id = :id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['id' => $id]);
        $data = $query->fetch();

        if (!$data) {
            return null;
        }

        $book = new Book($data);

        return $book;
    }

    public function getBooksByOwnerId(string $ownerId): array
    {
        $sql = "SELECT *
                FROM books
                WHERE owner_id LIKE :owner_id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['owner_id' => $ownerId]);

        $books = [];

        while ($data = $query->fetch()) {
            $books[] = new Book($data);
        }

        return $books;
    }

    public function deleteBook(string $id, int $ownerId): void
    {
        $sql = "DELETE FROM books
                WHERE id = :id
                AND owner_id = :owner_id";

        $query = $this->db->getPDO()->prepare($sql);

        $query->execute([
            'id' => $id,
            'owner_id' => $ownerId
        ]);
    }

    public function updateBook(Book $book): void
    {
        $sql = "UPDATE books
                SET title = :title,
                    author = :author,
                    image = :image,
                    description = :description,
                    available = :available
                WHERE id = :id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
            'description' => $book->getDescription(),
            'available' => $book->isAvailable() ? 1 : 0,
            'id' => $book->getId(),
        ]);
    }
}