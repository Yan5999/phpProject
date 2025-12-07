<?php

namespace Yan\Composer\Models;

use Yan\Composer\Database;
use PDO;

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function create($username, $email, $password)
    {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        
        try {
            return $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $passwordHash
            ]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}