<?php
class Admin {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getDashboardStats() {
        $this->db->query("SELECT
            (SELECT COUNT(*) FROM users) as total_users,
            (SELECT COUNT(*) FROM transactions) as total_transactions,
            (SELECT SUM(amount) FROM transactions WHERE status = 'Success') as total_revenue
        ");
        return $this->db->single();
    }

    public function getRecentTransactions() {
        $this->db->query("SELECT * FROM transactions ORDER BY created_at DESC LIMIT 5");
        return $this->db->resultSet();
    }

    public function getUsers() {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultSet();
    }

    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateUser($data) {
        $this->db->query("UPDATE users SET name = :name, email = :email, wallet_balance = :wallet_balance, bonus_balance = :bonus_balance, is_admin = :is_admin WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':wallet_balance', $data['wallet_balance']);
        $this->db->bind(':bonus_balance', $data['bonus_balance']);
        $this->db->bind(':is_admin', $data['is_admin']);
        return $this->db->execute();
    }

    public function getSettings() {
        $this->db->query("SELECT * FROM settings");
        $results = $this->db->resultSet();

        $settings = [];
        foreach ($results as $result) {
            $settings[$result->name] = $result->value;
        }
        return $settings;
    }

    public function updateSettings($settings) {
        foreach ($settings as $name => $value) {
            $this->db->query("UPDATE settings SET value = :value WHERE name = :name");
            $this->db->bind(':value', $value);
            $this->db->bind(':name', $name);
            $this->db->execute();
        }
        return true;
    }
}
