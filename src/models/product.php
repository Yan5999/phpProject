<?php

namespace Yan\Composer\Models;

use Yan\Composer\Database;
use PDO;

class Product
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                description TEXT
            )
        ");
    }


    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $price, $description = '')
    {
        $sql = "INSERT INTO products (name, price, description) VALUES (:name, :price, :description)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':description' => $description
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}