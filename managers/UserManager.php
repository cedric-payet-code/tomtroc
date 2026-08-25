<?php

class UserManager extends AbstractManager
{
    public function getUserById(string $id): User
    {
        $sql = "SELECT *
                FROM users
                WHERE id = :id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['id' => $id]);
        $data = $query->fetch();

        $user = new User($data);

        return $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['email' => $email]);

        $data = $query->fetch();

        if (!$data) {
            return null;
        }

        $user = new User($data);

        return $user;
    }

    public function getUserByUsername(string $username): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute(['username' => $username]);

        $data = $query->fetch();

        if (!$data) {
            return null;
        }

        $user = new User($data);

        return $user;
    }

    public function createUser(User $user): void
    {
        $sql = "INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);
    }
    
    public function updateUser(User $user): void
    {
        $sql = "UPDATE users
                SET username = :username,
                    email = :email,
                    password = :password
                WHERE id = :id";

        $query = $this->db->getPDO()->prepare($sql);
        $query->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'id' => $user->getId(),
        ]);
    }
}