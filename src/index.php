<?php
session_start();

require_once __DIR__ . '/Controller/LoginController.php';
require_once __DIR__ . '/Controller/DashboardController.php';
require_once __DIR__ . '/Controller/UserController.php';

use Src\Controller\LoginController;
use Src\Controller\DashboardController;

$routes = [
    'dashboard' => [DashboardController::class, 'index'],
    'login' => [LoginController::class, 'index'],
    'logout' => [LoginController::class, 'logout'],
    'create_user' => [\Src\Controller\UserController::class, 'createUser'],
    'mon_compte' => [\Src\Controller\UserController::class, 'monCompte'],
];

$page = $_GET['page'] ?? 'login';
$route = $routes[$page] ?? $routes['login'];

$controller = new $route[0]();
$method = $route[1];
$controller->$method();
