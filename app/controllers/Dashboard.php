<?php
class Dashboard extends Controller {
    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if pin is verified
        if (!isset($_SESSION['pin_verified'])) {
            redirect('users/pin');
        }

        $this->userModel = $this->model('User');
        $this->transactionModel = $this->model('Transaction');
    }

    public function index() {
        $user = $this->userModel->getUserById($_SESSION['user_id']);

        $data = [
            'user' => $user
        ];

        $this->view('dashboard/index', $data);
    }

    public function history() {
        $transactions = $this->transactionModel->getTransactionsByUserId($_SESSION['user_id']);

        $data = [
            'transactions' => $transactions
        ];

        $this->view('dashboard/history', $data);
    }
}
