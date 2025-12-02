<?php
class Data extends Controller {
    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if pin is verified
        if (!isset($_SESSION['pin_verified'])) {
            redirect('users/pin');
        }

        $this->dataModel = $this->model('Data');
        $this->userModel = $this->model('User');
        $this->transactionModel = $this->model('Transaction');
    }

    public function index() {
        $data = [
            'data_plans' => $this->dataModel->getDataPlans()
        ];

        $this->view('data/index', $data);
    }

    public function purchase() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!validate_csrf_token($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $data_plan_id = trim($_POST['data_plan']);
            $data_plan = $this->dataModel->getDataPlanById($data_plan_id);
            $user = $this->userModel->getUserById($_SESSION['user_id']);

            $data = [
                'data_plan_id' => $data_plan_id,
                'phone_number' => trim($_POST['phone_number']),
                'confirm_phone_number' => trim($_POST['confirm_phone_number']),
                'data_plan_err' => '',
                'phone_number_err' => '',
                'confirm_phone_number_err' => ''
            ];

            // Validate data
            if (empty($data['data_plan_id'])) {
                $data['data_plan_err'] = 'Please select a data plan';
            }
            if (empty($data['phone_number'])) {
                $data['phone_number_err'] = 'Please enter a phone number';
            }
            if (empty($data['confirm_phone_number'])) {
                $data['confirm_phone_number_err'] = 'Please confirm the phone number';
            }
            if ($data['phone_number'] != $data['confirm_phone_number']) {
                $data['confirm_phone_number_err'] = 'Phone numbers do not match';
            }
            if ($user->wallet_balance < $data_plan->price) {
                $data['data_plan_err'] = 'Insufficient wallet balance';
            }

            // Check for duplicate transaction
            $recent_transaction = $this->transactionModel->findRecentTransaction($_SESSION['user_id'], $data['data_plan_id'], $data['phone_number']);
            if ($recent_transaction) {
                $data['data_plan_err'] = 'Duplicate transaction detected. Please wait a minute before trying again.';
            }

            // Make sure errors are empty
            if (empty($data['data_plan_err']) && empty($data['phone_number_err']) && empty($data['confirm_phone_number_err'])) {
                // Process purchase
                // 1. Deduct from wallet
                $this->dataModel->updateWalletBalance($_SESSION['user_id'], $data_plan->price);

                // 2. Record transaction as pending
                $this->dataModel->recordTransaction(
                    $_SESSION['user_id'],
                    'data',
                    $data_plan->price,
                    'pending',
                    $data['phone_number'],
                    $data['data_plan_id']
                );

                // Redirect to a success page
                flash('purchase_success', 'Your data purchase is being processed.');
                redirect('dashboard');

            } else {
                // Load view with errors
                $data['data_plans'] = $this->dataModel->getDataPlans();
                $this->view('data/index', $data);
            }
        } else {
            redirect('data');
        }
    }
}
