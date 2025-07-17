<?php

namespace Src\Controller;

class DashboardController
{
    public function index()
    {
        $logs = [
            ['message' => 'Log 1 : système démarré'],
            ['message' => 'Log 2 : utilisateur connecté'],
            ['message' => 'Log 3 : erreur critique détectée'],
        ];

        require __DIR__ . '/../View/logs.php';
    }
}

