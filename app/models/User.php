<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Get user by id
    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }

    // Register user
    public function register($data) {
        $this->db->query("INSERT INTO users (name, email, password, pin) VALUES (:name, :email, :password, :pin)");
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':pin', $data['pin']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Login user
    public function login($email, $password) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function updateWalletBalance($user_id, $amount, $action = 'subtract') {
        if ($action == 'add') {
            $this->db->query("UPDATE users SET wallet_balance = wallet_balance + :amount WHERE id = :user_id");
        } else {
            $this->db->query("UPDATE users SET wallet_balance = wallet_balance - :amount WHERE id = :user_id");
        }
        $this->db->bind(':amount', $amount);
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }

    public function createPasswordResetToken($email, $token) {
        $this->db->query("INSERT INTO password_resets (email, token) VALUES (:email, :token)");
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }

    public function getPasswordResetToken($token) {
        $this->db->query("SELECT * FROM password_resets WHERE token = :token AND created_at >= NOW() - INTERVAL 1 HOUR");
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function getUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function updatePassword($user_id, $password) {
        $this->db->query("UPDATE users SET password = :password WHERE id = :user_id");
        $this->db->bind(':password', $password);
        return $this->db->execute();
    }

    public function deletePasswordResetToken($email) {
        $this->db->query("DELETE FROM password_resets WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }

    public function updatePin($user_id, $pin) {
        $this->db->query("UPDATE users SET pin = :pin WHERE id = :user_id");
        $this->db->bind(':pin', $pin);
        return $this->db->execute();
    }
}
