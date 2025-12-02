<?php
class Payment {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getGatewaySettings($gateway) {
        $this->db->query("SELECT * FROM settings WHERE name LIKE :gateway");
        $this->db->bind(':gateway', $gateway . '%');
        $results = $this->db->resultSet();

        $settings = [];
        foreach ($results as $result) {
            $key = str_replace($gateway . '_', '', $result->name);
            $settings[$key] = $result->value;
        }

        return $settings;
    }

    public function creditUserWallet($user_id, $amount) {
        $this->db->query("UPDATE users SET wallet_balance = wallet_balance + :amount WHERE id = :user_id");
        $this->db->bind(':amount', $amount);
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }

    public function logPayment($user_id, $amount, $reference, $gateway, $status) {
        $this->db->query("INSERT INTO transactions (user_id, service, amount, status, reference, gateway) VALUES (:user_id, 'Wallet Funding', :amount, :status, :reference, :gateway)");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':status', $status);
        $this->db->bind(':reference', $reference);
        $this->db->bind(':gateway', $gateway);
        return $this->db->execute();
    }
}
