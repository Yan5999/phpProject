<?php

namespace Classes;

use Classes\AuthController;

use Latte\Engine;

class Viewer {
    public static function show(string $page, array $param = []): void
    {
        $latte = new Engine();

        $latte->setTempDirectory(__DIR__ . DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'temp');

        $baseDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'templates';
        $layoutPath = $baseDir . DIRECTORY_SEPARATOR . '@layout.latte';
        $pagePath = $baseDir . DIRECTORY_SEPARATOR . $page . '.latte';

        if (!file_exists($pagePath)) {
            throw new \RuntimeException("Template not found: $pagePath");
        }

        $param['contentTemplate'] = $pagePath;
        
        // Додаємо до параметрів user (якщо є в сесії) та CSRF токен для захисту форм
        $param['user'] = $_SESSION['login'] ?? null;
        $param['csrf_token'] = AuthController::generateCsrfToken();

        $param['error'] = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']); // Видаляємо повідомлення після відображення
        
        $latte->render($layoutPath, $param);
    }
}
