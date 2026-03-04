<?php

use App\Controllers\ContactController;
use App\Controllers\IndexController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\RegisterController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use Core\Route;

(new Route)
    ->get('/contacts', IndexController::class, AuthMiddleware::class)
    ->get('/login', [LoginController::class, 'index'], GuestMiddleware::class)
    ->post('/login', [LoginController::class, 'login'], GuestMiddleware::class)
    ->get('/register', [RegisterController::class, 'index'], GuestMiddleware::class)
    ->post('/register', [RegisterController::class, 'register'], GuestMiddleware::class)
    ->get('/logout', LogoutController::class, AuthMiddleware::class)

    ->post('/contacts', [ContactController::class, 'store'], AuthMiddleware::class)
    ->put('/contacts', [ContactController::class, 'update'], AuthMiddleware::class)
    ->delete('/contacts', [ContactController::class, 'destroy'], AuthMiddleware::class)
    ->run();
