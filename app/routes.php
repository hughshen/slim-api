<?php

use Slim\App;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\AuthController;
use App\Middlewares\PermissionMiddleware;

$app->get('/', HomeController::class . ':index')->setName('home');

$app->post('/api/login', AuthController::class . ':login');

$app->group('/api', function(App $app) {
    $app->get('/post', PostController::class . ':index');
    $app->post('/post', PostController::class . ':save');
    $app->get('/post/{id}', PostController::class . ':show');
    $app->patch('/post/{id}', PostController::class . ':update');
    $app->delete('/post/{id}', PostController::class . ':delete');
})->add(new PermissionMiddleware());