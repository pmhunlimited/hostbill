<?php
class ManualDeposit {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addDeposit($user_id, $amount, $proof) {
        $this->db->query("INSERT INTO manual_deposits (user_id, amount, proof) VALUES (:user_id, :amount, :proof)");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':proof', $proof);
        return $this->db->execute();
    }

    public function getPendingDeposits() {
        $this->db->query("SELECT md.*, u.email FROM manual_deposits md JOIN users u ON md.user_id = u.id WHERE md.status = 'pending'");
        return $this->db->resultSet();
    }

    public function getDepositById($id) {
        $this->db->query("SELECT * FROM manual_deposits WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateDepositStatus($id, $status) {
        $this->db->query("UPDATE manual_deposits SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
