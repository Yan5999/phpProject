<?php
namespace Yan\Composer\Controllers;
use Yan\Composer\Models\User;

class AuthController
{
    public function registerPost()
    {
        $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        $userModel = new User();

        if ($userModel->create($username, $email, $password)) {
            header('Location: /login');
        } else {
            echo "Помилка реєстрації (можливо, email зайнятий)";
        }
    }

    public function loginPost()
    {
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            
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