<?php

namespace Yan\Composer\Controllers;
use Latte\Engine;

class PageController
{
    private $latte;

    public function __construct()
    {
        
        $this->latte = new Engine;
       
        $this->latte->setTempDirectory(__DIR__ . '/../../cache');
        
        $this->latte->setAutoRefresh(true);
    }

    public function home()
    {
        $params = [
            'title' => 'Головна сторінка'
        ];
  
        $this->latte->render(__DIR__ . '/../templates/home.latte', $params);
    }

    public function login()
    {
        $params = [
            'title' => 'Логін'
        ];
        $this->latte->render(__DIR__ . '/../templates/log.latte', $params);
    }

    public function register()
    {
        $params = [
            'title' => 'Реєстрація'
        ];
        $this->latte->render(__DIR__ . '/../templates/reg.latte', $params);
    }

    public function notFound()
    {
        http_response_code(404);
        $params = [
            'title' => '404 - Не знайдено'
        ];
        $this->latte->render(__DIR__ . '/../templates/404.latte', $params);
    }
}