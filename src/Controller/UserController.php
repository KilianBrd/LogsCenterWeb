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

    public function monCompte() {
        if (!isset($_SESSION['email'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $user = \Src\Model\User::findByEmail($_SESSION['email']);
        $message = null;
        $type = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
            $username = $_POST['username'] ?? $user->getUsername();
            $email = $_POST['email'] ?? $user->getEmail();
            $password = $_POST['password'] ?? '';
            $user->setUsername($username);
            $user->setEmail($email);
            if (!empty($password)) {
                $user->setPassword($password);
            }
            if ($user->update()) {
                $_SESSION['email'] = $email;
                $message = 'Modifications enregistrées avec succès !';
                $type = 'success';
            } else {
                $message = 'Erreur lors de la modification.';
                $type = 'error';
            }
        }
        require __DIR__ . '/../View/mon_compte.php';
    }

    public function supprimerCompte() {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $user = \Src\Model\User::findByEmail($_SESSION['email']);
        if ($user && $user->delete()) {
            session_unset();
            session_destroy();
            header('Location: index.php?page=login');
            exit;
        } else {
            $_SESSION['moncompte_message'] = "Erreur lors de la suppression du compte.";
            $_SESSION['moncompte_type'] = 'error';
            header('Location: index.php?page=mon_compte');
            exit;
        }
    }

    public function gestionUtilisateurs() {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        $userModel = new \Src\Model\User();
        $users = $userModel->getAllUsers();
        $message = $_SESSION['gestion_user_message'] ?? null;
        $type = $_SESSION['gestion_user_type'] ?? null;
        unset($_SESSION['gestion_user_message'], $_SESSION['gestion_user_type']);
        require __DIR__ . '/../View/gestion_utilisateurs.php';
    }

    public function supprimerUtilisateur() {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        $id = $_POST['id'] ?? null;
        if ($id) {
            $user = new \Src\Model\User();
            $user->setId($id);
            if ($user->delete()) {
                $_SESSION['gestion_user_message'] = 'Utilisateur supprimé avec succès !';
                $_SESSION['gestion_user_type'] = 'success';
            } else {
                $_SESSION['gestion_user_message'] = 'Erreur lors de la suppression.';
                $_SESSION['gestion_user_type'] = 'error';
            }
        }
        header('Location: index.php?page=gestion_utilisateurs');
        exit;
    }
} 