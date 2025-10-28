<?php
use Pecee\SimpleRouter\SimpleRouter;
SimpleRouter::get('/', function() {
    $title = 'Головна';
    include __DIR__ . '/templates/nav.php';
    include __DIR__ . '/templates/home.php';
});
SimpleRouter::get('/login', function() {
    $title = 'Логін';
    include __DIR__ . '/templates/nav.php';
    include __DIR__ . '/templates/log.php';
});
SimpleRouter::get('/register', function() {
    $title = 'Реєстрація';
    include __DIR__ . '/templates/nav.php';
    include __DIR__ . '/templates/reg.php';
});

SimpleRouter::error(function(\Pecee\Http\Request $request, \Exception $exception) {
    http_response_code(404);
    $title = '404 - Не знайдено';
    include __DIR__ . '/templates/404.php';
});
