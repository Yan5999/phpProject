<?php
use Pecee\SimpleRouter\SimpleRouter;
use Yan\Composer\Controllers\PageController;
use Yan\Composer\Controllers\AuthController; 


SimpleRouter::get('/', [PageController::class, 'home']);
SimpleRouter::get('/login', [PageController::class, 'login']);
SimpleRouter::get('/register', [PageController::class, 'register']);

SimpleRouter::post('/register', [AuthController::class, 'registerPost']);
SimpleRouter::post('/login', [AuthController::class, 'loginPost']);
SimpleRouter::get('/logout', [AuthController::class, 'logout']);

SimpleRouter::error(function(\Pecee\Http\Request $request, \Exception $exception) {
    $controller = new PageController();
    $controller->notFound();
});