<?php
namespace Yan\Composer\Controllers;
use Yan\Composer\Database;
class AuthController
{

    public function registerPost()
    {
        $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        
        $password = $_POST['password'] ?? '';

        if (Database::register($username, $email, $password)) {
            header('Location: /login');
        } else {
            echo "Помилка реєстрації (можливо, email зайнятий)";
        }
    }


    public function loginPost()
    {
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
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