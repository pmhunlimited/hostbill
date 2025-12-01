<?php
class Data {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getDataPlans() {
        $this->db->query("SELECT * FROM data_plans");
        return $this->db->resultSet();
    }

    public function getDataPlanById($id) {
        $this->db->query("SELECT * FROM data_plans WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function recordTransaction($user_id, $service, $amount, $status, $phone_number, $data_plan_id) {
        $this->db->query("INSERT INTO transactions (user_id, service, amount, status, phone_number, data_plan_id) VALUES (:user_id, :service, :amount, :status, :phone_number, :data_plan_id)");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':service', $service);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':status', $status);
        $this->db->bind(':phone_number', $phone_number);
        $this->db->bind(':data_plan_id', $data_plan_id);
        $this->db->execute();
    }

    public function getPendingTransactions() {
        $this->db->query("SELECT * FROM transactions WHERE service = 'data' AND status = 'pending'");
        return $this->db->resultSet();
    }

    public function updateTransactionStatus($id, $status) {
        $this->db->query("UPDATE transactions SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function updateWalletBalance($user_id, $amount) {
        $this->db->query("UPDATE users SET wallet_balance = wallet_balance - :amount WHERE id = :user_id");
        $this->db->bind(':amount', $amount);
        $this->db->bind(':user_id', $user_id);
        $this->db->execute();
    }

    public function updateDataPlanCostPrice($id, $cost_price) {
        $this->db->query("UPDATE data_plans SET cost_price = :cost_price WHERE id = :id");
        $this->db->bind(':cost_price', $cost_price);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
