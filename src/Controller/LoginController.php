<?php 

namespace Src\Controller;

// Teste sans autoload d'abord
require_once __DIR__ . '/../Model/Database.php';

class LoginController {
    private $db;

    public function __construct() {
        
        try {
            $this->db = new \Src\Model\Database();
        } catch (\Exception $e) {
            echo "❌ Erreur de connexion à la base : " . $e->getMessage() . "<br>";
            echo "=== FIN TEST DB (avec erreur) ===<br>";
        }
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
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

        echo 'passe';

        if ($this->authenticate($username, $password)) {

            $_SESSION['user_id'] = $username;
            $_SESSION['logged_in'] = true;

            echo "<div style='color: green; background: #e8f5e9; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
            echo "✅ Connexion réussie ! Bienvenue, " . htmlspecialchars($username) . " !";
            echo "</div>";
        } else {
            $this->showError("Identifiants incorrects");
        }
    }

    private function authenticate($username, $password) {
        if (!$this->db) {
            return false;
        }
        
        $conn = $this->db->getConnection();
        
        $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($password == $user['password_hash']) {
                return true;
            }

            if (password_verify($password, $user['password_hash'])) {
                return true;
            }
        }
        
        return false;
    }

    private function showError($message) {
        echo "<div style='color: red; background: #ffebee; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
        echo "❌ " . htmlspecialchars($message);
        echo "</div>";
    }
}