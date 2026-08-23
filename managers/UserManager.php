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

        $user = new User();
        $user->setId($data['id']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setAvatar($data['avatar']);
        $user->setCreatedAt($data['created_at']);

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
    
}