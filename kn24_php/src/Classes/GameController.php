<?php

namespace Classes;

use Classes\Database;

class GameController{

    public function show(){
        // 1. Підключення та створення БД
        $conn = Database::connect();
        if ($conn) {
            // 2. Отримання даних (використовуємо метод select)
            $gamesList = Database::select("SELECT id, title, description FROM games");
            // 3. Передаємо дані в шаблон
            Viewer::show('game', [
                'title' => 'Cторінка ігр',
                'gamesList' => $gamesList
            ]);
        }
    }

    public function addToDatabase(){
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Додавання даних (використовуємо метод query)
        $insert_sql = "
            INSERT INTO games (title, description) 
            VALUES ('$title', '$description')
        ";
        
        Database::query($insert_sql);
        header('Location: /game');
        exit;
    }
}