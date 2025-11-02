<?php
namespace Classes;

use Classes\Viewer;

class ErrorController
{
    public static function show404(): void
    {
        http_response_code(404);
        Viewer::show('error404', [
            'title' => 'Сторінку не знайдено',
            'errorCode' => 404,
            'message' => 'На жаль, запитану сторінку не знайдено.'
        ]);
    }

    public static function show500(?\Throwable $e = null): void
    {
    
        http_response_code(500);
        Viewer::show('error500', [
            'title' => 'Помилка сервера',
            'errorCode' => 500,
            'message' => $e ? $e->getMessage() : 'Невідома помилка сервера.'
        ]);
    }

    public static function show403(?\Throwable $e = null): void
    {
        http_response_code(403);

        Viewer::show('error403', [
            'title' => 'Доступ заборонено',
            'errorCode' => 403,
            'message' => $e ? $e->getMessage() : 'У вас немає прав для перегляду цієї сторінки.'
        ]);
    }
}
