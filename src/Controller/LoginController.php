<?php 

namespace Src\Controller;

use User;

require_once __DIR__ . '/../Model/Database.php';

class LoginController {
    private $db;
    public $results;

    public function __construct() {
        session_start();
        try {
            $this->db = new \Src\Model\Database();
        } catch (\Exception $e) {
            $_SESSION['login_error'] = "Erreur de connexion à la base : " . $e->getMessage();
        }
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
        }

        $message = null;
        $type = null;

        if (isset($_SESSION['login_error'])) {
            $message = $_SESSION['login_error'];
            $type = 'error';
            unset($_SESSION['login_error']);
        }

        if (isset($_SESSION['login_success'])) {
            $message = $_SESSION['login_success'];
            $type = 'success';
            unset($_SESSION['login_success']);
        }

        require __DIR__ . '/../View/login.php';
    }

    private function handleLogin() {
        $username = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $this->showError("Veuillez remplir tous les champs");
            return;
        }

        if ($this->authenticate($username, $password)) {
            $_SESSION['login_success'] = "Connexion réussie !";
            $_SESSION['email'] = $username;
            $_SESSION['logged_in'] = true;
            header('Location: index.php?page=dashboard');
            exit;
        } else {
            $this->showError("Identifiants incorrects");
        }
    }

    private function authenticate($username, $password) {
        if (!$this->db) {
            return false;
        }

        $conn = $this->db->getConnection();

        $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            

            if ($password === $user['password_hash']) {
                $_SESSION['role'] = $user['role'];
                return true;
                
            }

            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }

        return false;
    }

    private function showError($message) {
        $_SESSION['login_error'] = $message;
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
