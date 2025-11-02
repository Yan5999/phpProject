<?php
    require __DIR__ .'/../vendor/autoload.php';

    session_start();
          
    // маршрутизатор
    use Pecee\SimpleRouter\SimpleRouter;
    use Pecee\Http\Request;
    use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

    use Classes\HomePageController;
    use Classes\ErrorController;
    use Classes\LoginController;
    use Classes\AuthController;
    use Classes\GameController;
    use Classes\RegController;
    use Classes\AboutMeController;

    // прописуємо маршрути
    SimpleRouter::get('/', [HomePageController::class, 'show']);
    
    SimpleRouter::get('/login', [LoginController::class, 'show']);

    SimpleRouter::get('/aboutme', [AboutMeController::class, 'show']);

    SimpleRouter::get('/reg', [RegController::class, 'show']);
    
    SimpleRouter::get('/logout', [AuthController::class, 'logout']);
    SimpleRouter::post('/login', [AuthController::class, 'login']);
    SimpleRouter::post('/reg', [AuthController::class, 'reg']);
    
    // робимо нову сторінку
    SimpleRouter::get('/game', [GameController::class, 'show']);
    SimpleRouter::post('/game', [GameController::class, 'addToDatabase']);

    // --- обробка помилок ---

    SimpleRouter::error(function(Request $r, \Exception $e) {
        if ($e instanceof NotFoundHttpException) {
            ErrorController::show404();
        } elseif ($e->getCode() === 403) {
            ErrorController::show403($e);
        } else {
            ErrorController::show500($e);
        }
        exit;
    });

     // Запуск маршрутизатора
    SimpleRouter::start();