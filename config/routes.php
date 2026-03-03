<?php

use App\Controllers\IndexController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\NotesController;
use App\Controllers\RegisterController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use Core\Route;

(new Route)
    ->get('/notes', IndexController::class, AuthMiddleware::class)
    ->get('/login', [LoginController::class, 'index'], GuestMiddleware::class)
    ->post('/login', [LoginController::class, 'login'], GuestMiddleware::class)
    ->get('/register', [RegisterController::class, 'index'], GuestMiddleware::class)
    ->post('/register', [RegisterController::class, 'register'], GuestMiddleware::class)
    ->get('/logout', LogoutController::class, AuthMiddleware::class)
    ->get('/notes/create', [NotesController::class, 'index'], AuthMiddleware::class)
    ->post('/notes', [NotesController::class, 'store'], AuthMiddleware::class)
    ->put('/notes', [NotesController::class, 'update'], AuthMiddleware::class)
    ->delete('/notes', [NotesController::class, 'destroy'], AuthMiddleware::class)
    ->get('/notes/confirm', [NotesController::class, 'confirm'], AuthMiddleware::class)
    ->post('/notes/show', [NotesController::class, 'show'], AuthMiddleware::class)
    ->get('/notes/hidden', [NotesController::class, 'hidden'], AuthMiddleware::class)
    ->run();
