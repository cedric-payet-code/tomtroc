<?php

class BookManager extends AbstractManager
{
    public function getLatestBooks(): array
    {
        $sql = "SELECT
                    books.*,
                    users.id AS user_id,
                    users.username,
                    users.avatar
                FROM books
                JOIN users ON books.owner_id = users.id
                WHERE books.available = 1
                ORDER BY books.id DESC
                LIMIT 4";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute();

        $latestBooks = [];

        while ($data = $query->fetch()) {
            $book = new Book($data);

            $owner = new User();
            $owner->setId($data['user_id']);
            $owner->setUsername($data['username']);

            $latestBooks[] = [
                'book' => $book,
                'owner' => $owner,
            ];
        }

        return $latestBooks;
    }

    public function getBook(string $id): array
    {
        $sql = "SELECT
                    books.*,
                    users.id AS user_id,
                    users.username,
                    users.avatar
                FROM books
                JOIN users ON books.owner_id = users.id
                WHERE books.id = :id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['id' => $id]);
        $data = $query->fetch();

        if (!$data) {
            return [];
        }

        $book = new Book($data);

        $owner = new User();
        $owner->setId($data['user_id']);
        $owner->setUsername($data['username']);
        $owner->setAvatar($data['avatar']);

        return 
        [
            'book' => $book,
            'owner' => $owner,
        ];
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
            null;
        }

        $book = new Book($data);

        return $book;
    }

    public function getBooks(): array
    {
        $sql = "SELECT
                    books.*,
                    users.id AS user_id,
                    users.username,
                    users.avatar
                FROM books
                JOIN users ON books.owner_id = users.id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute();

        $books = [];

        while ($data = $query->fetch()) {
            $book = new Book($data);

            $owner = new User();
            $owner->setId($data['user_id']);
            $owner->setUsername($data['username']);

            $books[] = [
                'book' => $book,
                'owner' => $owner,
            ];
        }

        return $books;
    }

    public function getBooksByTitle(string $search): array
    {
         $sql = "SELECT
                    books.*,
                    users.id AS user_id,
                    users.username,
                    users.avatar
                FROM books
                JOIN users ON books.owner_id = users.id
                WHERE title LIKE :search";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['search' => '%' . $search . '%']);

        $books = [];

        while ($data = $query->fetch()) {
            $book = new Book($data);

            $owner = new User();
            $owner->setId($data['user_id']);
            $owner->setUsername($data['username']);

            $books[] = [
                'book' => $book,
                'owner' => $owner,
            ];
        }

        return $books;
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
}