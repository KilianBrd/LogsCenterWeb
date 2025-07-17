<?php

require_once __DIR__ . '/Controller/LoginController.php';

use Src\Controller\LoginController;

$controller = new LoginController();
$controller->index();
