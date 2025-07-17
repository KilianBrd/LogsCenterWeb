<?php

namespace Src\Model;

class Database {
    private $conn;

    public function __construct() {
        $servername = "127.0.0.1:3306";
        $username = "root";
        $password = "";
        $dbname = "logscenter";


        $this->conn = new \mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("<strong>Erreur de connexion :</strong> " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public function getConnection() {
        return $this->conn;
    }
}
