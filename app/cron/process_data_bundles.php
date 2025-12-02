<?php
// Initialize the application
require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

class DataBundleProcessor {
    private $db;
    private $dataModel;
    private $apiKey;

    public function __construct() {
        $this->db = new Database;
        $this->dataModel = new Data;

        // Get API Key from settings
        $this->db->query("SELECT value FROM settings WHERE name = 'api_key'");
        $this->apiKey = $this->db->single()->value;
    }

    public function processPendingTransactions() {
        $transactions = $this->dataModel->getPendingTransactions();

        foreach ($transactions as $transaction) {
            $this->processTransaction($transaction);
        }
    }

    private function processTransaction($transaction) {
        $url = 'https://mtn.subfactory.net/api/v1/automated-gifting/';
        $data_plan = $this->dataModel->getDataPlanById($transaction->data_plan_id);

        $payload = [
            'network' => 'mtn', // Hardcoded for now
            'data_plan' => $data_plan->api_plan_id,
            'phone_number' => $transaction->phone_number,
            'confirm_phone_number' => $transaction->phone_number
        ];

        $headers = [
            'X-API-Key: ' . $this->apiKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response);

        if ($http_code == 200 && $result->success) {
            $this->dataModel->updateTransactionStatus($transaction->id, 'successful');

            // Update cost price if it has changed
            if ($result->data->amount_charged != $data_plan->cost_price) {
                $this->dataModel->updateDataPlanCostPrice($data_plan->id, $result->data->amount_charged);
            }
        } else {
            $this->dataModel->updateTransactionStatus($transaction->id, 'failed');
            // Refund the user
            $userModel = new User;
            $userModel->updateWalletBalance($transaction->user_id, $transaction->amount, 'add');
        }
    }
}

$processor = new DataBundleProcessor();
$processor->processPendingTransactions();
