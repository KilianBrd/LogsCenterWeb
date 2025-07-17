<?php

namespace Src\Model;

class Database {
    private $conn;

    //Connexion à la bdd

    public function __construct() {
        $this->loadEnv();

        $servername = $_ENV['DBURL'] ?? '127.0.0.1:3306';
        $username = $_ENV['DBUSERNAME'] ?? 'root';
        $password = $_ENV['DBPASSWORD'] ?? '';
        $dbname = $_ENV['DBNAME'] ?? '';


        $this->conn = new \mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("<strong>Erreur de connexion :</strong> " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public function getConnection() {
        return $this->conn;
    }

    //Load les variables du .env dans la var globale $_ENV

    private function loadEnv() {
        $envFile = __DIR__ . '/../../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $_ENV[trim($key)] = trim($value);
                }
            }
        }
    }
}
