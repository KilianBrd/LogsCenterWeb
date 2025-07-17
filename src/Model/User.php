<?php

namespace Src\Model;

require_once __DIR__ . '/Database.php';

class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $createdAt;

    public function __construct($id = null, $username = null, $email = null, $password = null, $role = null, $createdAt = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->createdAt = $createdAt;
    }

    public function getId() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getRole() {
        return $this->role;
    }
    public function getCreatedAt() {
        return $this->createdAt;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setRole($role) {
        $this->role = $role;
    }

    // Créer un utilisateur en base de données
    public function save() {
        $db = new Database();
        $conn = $db->getConnection();
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (username, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())');
        $stmt->bind_param('ssss', $this->username, $this->email, $password_hash, $this->role);
        if ($stmt->execute()) {
            $this->id = $conn->insert_id;
            return true;
        }
        return false;
    }

    // Charger un utilisateur par email
    public static function findByEmail($email) {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('SELECT id, username, email, password_hash, role, created_at FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return new User($row['id'], $row['username'], $row['email'], $row['password_hash'], $row['role'], $row['created_at']);
        }
        return null;
    }

    public function update() {
        $db = new Database();
        $conn = $db->getConnection();
        if (!empty($this->password)) {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('UPDATE users SET username = ?, email = ?, password_hash = ? WHERE id = ?');
            $stmt->bind_param('sssi', $this->username, $this->email, $password_hash, $this->id);
        } else {
            $stmt = $conn->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
            $stmt->bind_param('ssi', $this->username, $this->email, $this->id);
        }
        return $stmt->execute();
    }

    public function delete() {
        if (!$this->id) return false;
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }
}