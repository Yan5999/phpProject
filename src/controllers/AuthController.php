<?php

namespace Yan\Composer\Controllers;

use Yan\Composer\Database;

class AuthController
{

    public function registerPost()
    {
   
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Database::register($username, $email, $password)) {
       
            header('Location: /login');
        } else {
     
            echo "Помилка реєстрації (можливо, email зайнятий)";
    
        }
    }


    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = Database::checkUser($email, $password);

        if ($user) {
   
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            
            header('Location: /'); 
        } else {
            echo "Невірний логін або пароль";
        }
    }
    
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }
}