<?php

namespace Classes;

class Database {
    // Властивості (без змін)
    private static string $host = 'localhost';
    private static string $pass = '';
    private static string $user = 'root';
    private static string $db = 'mydatabase';
    
    private static ?\mysqli $connection = null;

    /**
     * Встановлює підключення до бази даних та ініціалізує її структуру.
     */
    public static function connect(): \mysqli|false {
        if (self::$connection) {
            return self::$connection; // Повертаємо існуюче підключення
        }
        
        // 1. Спроба підключитися БЕЗ вказання імені БД
        $conn_no_db = new \mysqli(self::$host, self::$user, self::$pass);

        if ($conn_no_db->connect_error) {
            die("Помилка підключення до MySQL: " . $conn_no_db->connect_error);
        }

        // 2. Створення бази даних, якщо вона не існує
        self::createDatabaseIfNotExists($conn_no_db);
        $conn_no_db->close(); // Закриваємо тимчасове підключення

        // 3. Створення підключення З вказанням імені БД
        self::$connection = new \mysqli(self::$host, self::$user, self::$pass, self::$db);
        
        if (self::$connection->connect_error) {
            die("Помилка підключення до бази даних " . self::$db . ": " . self::$connection->connect_error);
        }
        
        self::$connection->set_charset("utf8mb4");

        // 4. СТВОРЕННЯ ТАБЛИЦЬ (ВИКЛИКАЄТЬСЯ ПІСЛЯ УСПІШНОГО ПІДКЛЮЧЕННЯ ДО БД)
        self::createTablesIfNotExists(self::$connection);

        return self::$connection;
    }

    /**
     * Створює базу даних, якщо вона не існує.
     * @param \mysqli $conn Об'єкт підключення без вказання імені БД.
     */
    private static function createDatabaseIfNotExists(\mysqli $conn): void {
        $sql = "CREATE DATABASE IF NOT EXISTS " . self::$db;
        
        // Ми просто перевіряємо, чи запит не впав
        if ($conn->query($sql) === FALSE) {
            // Це критична помилка, якщо ми не можемо створити БД
            die("Помилка при створенні бази даних: " . $conn->error);
        }
    }

    /**
     * (НОВИЙ МЕТОД)
     * Створює необхідні таблиці, якщо вони не існують.
     * @param \mysqli $conn Об'єкт підключення ВЖЕ З ВИБРАНОЮ БД.
     */
    private static function createTablesIfNotExists(\mysqli $conn): void {
        $create_table_sql = "
        CREATE TABLE IF NOT EXISTS games (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(30) NOT NULL,
            description TEXT NOT NULL
        );
        ";
        
        // Виконуємо запит на створення таблиці
        if ($conn->query($create_table_sql) === FALSE) {
            die("Помилка при створенні таблиці 'games': " . $conn->error);
        }
        
        // Тут можна додати створення інших таблиць (наприклад, 'users')
        $create_table_sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(30) NOT NULL,
            password VARCHAR(30) NOT NULL
        );
        ";

        // Виконуємо запит на створення таблиці
        if ($conn->query($create_table_sql) === FALSE) {
            die("Помилка при створенні таблиці 'users': " . $conn->error);
        }
    }

    // --- (Решта методів: query, select, escape, getData, sendData залишаються без змін) ---

    public static function query(string $sql): bool|int {
        $conn = self::connect();
        $result = $conn->query($sql);

        if ($result === TRUE) {
            if ($conn->insert_id) {
                return $conn->insert_id;
            }
            return $conn->affected_rows > 0 ? $conn->affected_rows : TRUE;
        }

        if ($result === FALSE) {
            error_log("Помилка SQL-запиту: " . $conn->error . "\nЗапит: " . $sql);
            return FALSE;
        }
        return TRUE; 
    }

    public static function select(string $sql): array {
        $conn = self::connect();
        $result = $conn->query($sql);
        $data = [];

        if ($result === FALSE) {
            error_log("Помилка SELECT запиту: " . $conn->error . "\nЗапит: " . $sql);
            return [];
        }

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        $result->free(); 
        return $data;
    }

    public static function escape(string $value): string {
        $conn = self::connect();
        return $conn->real_escape_string($value);
    }
    
    public static function getData(){
        // Тепер можна безпечно отримувати дані з 'games'
        return self::select("SELECT * FROM games");
    }

    public static function sendData(){
        // Приклад:
        // $sql = "INSERT INTO games (title, description) VALUES ('" . self::escape($title) . "', '" . self::escape($desc) . "')";
        // return self::query($sql);
    }
}