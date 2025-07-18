<?php

namespace Src\Controller;

class DashboardController
{
    public function index()
    {
        require_once __DIR__ . '/../Model/Log.php';
        $logModel = new \Src\Model\Log(null, null, null, null, null, null, null, null, null);
        $logs = $logModel->getAllLogs();
        require __DIR__ . '/../View/logs.php';
    }
}

