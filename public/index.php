<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Pecee\SimpleRouter\SimpleRouter;
require_once __DIR__ . '/../src/routers.php';
SimpleRouter::start();

// php -S localhost:8000 -t public