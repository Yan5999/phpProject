<?php
use Pecee\SimpleRouter\SimpleRouter;
use Yan\Composer\Controllers\PageController; 

SimpleRouter::get('/', [PageController::class, 'home']);
SimpleRouter::get('/login', [PageController::class, 'login']);
SimpleRouter::get('/register', [PageController::class, 'register']);

SimpleRouter::error(function(\Pecee\Http\Request $request, \Exception $exception) {
    $controller = new PageController();
    $controller->notFound();
});