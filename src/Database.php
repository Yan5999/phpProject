<?php

namespace Yan\Composer;

use PDO;
use PDOException;

class Database
{
    private static $host = '127.0.0.1';
    private static $db_name = 'my_shop_db';
    private static $username = 'root';
    private static $password = '';

    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";charset=utf8mb4";              
                $conn = new PDO($dsn, self::$username, self::$password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->exec("CREATE DATABASE IF NOT EXISTS `" . self::$db_name . "`");
                $conn->exec("USE `" . self::$db_name . "`");
                $conn->exec("
                    CREATE TABLE IF NOT EXISTS users (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(50) NOT NULL,
                        email VARCHAR(100) NOT NULL UNIQUE,
                        password VARCHAR(255) NOT NULL
                    )
                ");

                self::$connection = $conn;

            } catch (PDOException $e) {

                echo "<h1>Критична помилка БД</h1>";
                echo "<p>" . $e->getMessage() . "</p>";
                die();
            }
        }
        return self::$connection;
    }

    public static function register($username, $email, $password)
    {
        $conn = self::getConnection();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($sql);
        
        try {
            return $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $passwordHash
            ]);
        } catch (PDOException $e) {

            return false;
        }
    }

    public static function checkUser($email, $password)
    {
        $conn = self::getConnection();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}