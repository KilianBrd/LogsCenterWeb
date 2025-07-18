<?php

namespace Src\Controller;

class DashboardController
{
    public function index()
    {
        require_once __DIR__ . '/../Model/Log.php';
        $logModel = new \Src\Model\Log(null, null, null, null, null, null, null, null, null);
        
        $logsPerPage = 20;
        $page = isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0 ? (int)$_GET['p'] : 1;
        $totalLogs = $logModel->countAllLogs();
        $totalPages = max(1, ceil($totalLogs / $logsPerPage));
        $offset = ($page - 1) * $logsPerPage;
        $logs = $logModel->getLogsPaginated($logsPerPage, $offset);
        
        require __DIR__ . '/../View/logs.php';
    }
}

