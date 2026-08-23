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
}