<?php

namespace Src\Controller;

require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/User.php';

use Src\Model\Database;

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createUser() {
        $message = null;
        $type = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            if (empty($username) || empty($email) || empty($password)) {
                $message = 'Veuillez remplir tous les champs.';
                $type = 'error';
            } else {
                $conn = $this->db->getConnection();
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare('INSERT INTO users (username, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())');
                $stmt->bind_param('ssss', $username, $email, $password_hash, $role);
                if ($stmt->execute()) {
                    $message = 'Utilisateur créé avec succès !';
                    $type = 'success';
                } else {
                    $message = "Erreur lors de la création de l'utilisateur : " . $conn->error;
                    $type = 'error';
                }
            }
        }
        require __DIR__ . '/../View/create_user.php';
    }
} 