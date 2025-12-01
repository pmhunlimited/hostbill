<?php
class Transaction {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getTransactionsByUserId($user_id) {
        $this->db->query("SELECT * FROM transactions WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function findRecentTransaction($user_id, $data_plan_id, $phone_number) {
        $this->db->query("SELECT * FROM transactions WHERE user_id = :user_id AND data_plan_id = :data_plan_id AND phone_number = :phone_number AND created_at >= NOW() - INTERVAL 1 MINUTE");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':data_plan_id', $data_plan_id);
        $this->db->bind(':phone_number', $phone_number);
        return $this->db->single();
    }
}
