<?php

namespace Src\Controller;

class LogController
{
    public function index()
    {
        // Exemple de données statiques, sans base de données
        $logs = [
            ['message' => 'Log 1 : système démarré'],
            ['message' => 'Log 2 : utilisateur connecté'],
            ['message' => 'Log 3 : erreur critique détectée'],
        ];

        // Inclusion de la vue qui affichera $logs
        require __DIR__ . '/../View/logs.php';
    }
}

