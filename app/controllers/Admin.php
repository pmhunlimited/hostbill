<?php
class Admin extends Controller {
    public function __construct() {
        // Check if user is logged in and is an admin
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            redirect('users/login');
        }

        $this->adminModel = $this->model('Admin');
        $this->manualDepositModel = $this->model('ManualDeposit');
        $this->userModel = $this->model('User');
    }

    private function isAdmin() {
        $user = $this->model('User')->getUserById($_SESSION['user_id']);
        return $user->is_admin;
    }

    public function index() {
        $stats = $this->adminModel->getDashboardStats();
        $recent_transactions = $this->adminModel->getRecentTransactions();

        $data = [
            'stats' => $stats,
            'recent_transactions' => $recent_transactions
        ];

        $this->view('admin/index', $data, true);
    }

    public function users() {
        $users = $this->adminModel->getUsers();
        $data = [
            'users' => $users
        ];
        $this->view('admin/users', $data, true);
    }

    public function edit_user($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!validate_csrf_token($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'wallet_balance' => trim($_POST['wallet_balance']),
                'bonus_balance' => trim($_POST['bonus_balance']),
                'is_admin' => isset($_POST['is_admin']) ? 1 : 0
            ];

            if ($this->adminModel->updateUser($data)) {
                redirect('admin/users');
            } else {
                die('Something went wrong');
            }
        } else {
            $user = $this->adminModel->getUserById($id);
            $data = [
                'user' => $user
            ];
            $this->view('admin/edit_user', $data, true);
        }
    }

    public function login_as_user($id) {
        $user = $this->adminModel->getUserById($id);
        // Create a new session for the user
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        // Make sure to unset the admin flag in the session
        unset($_SESSION['is_admin']);
        redirect('dashboard');
    }

    public function settings() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!validate_csrf_token($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $settings = [
                'flutterwave_public_key' => trim($_POST['flutterwave_public_key']),
                'flutterwave_secret_key' => trim($_POST['flutterwave_secret_key']),
                'paystack_public_key' => trim($_POST['paystack_public_key']),
                'paystack_secret_key' => trim($_POST['paystack_secret_key']),
                'api_key' => trim($_POST['api_key']),
                'smtp_host' => trim($_POST['smtp_host']),
                'smtp_user' => trim($_POST['smtp_user']),
                'smtp_pass' => trim($_POST['smtp_pass']),
                'smtp_port' => trim($_POST['smtp_port']),
            ];

            if ($this->adminModel->updateSettings($settings)) {
                redirect('admin/settings');
            } else {
                die('Something went wrong');
            }
        } else {
            $settings = $this->adminModel->getSettings();
            $data = [
                'settings' => $settings
            ];
            $this->view('admin/settings', $data, true);
        }
    }

    public function manual_deposits() {
        $deposits = $this->manualDepositModel->getPendingDeposits();
        $data = [
            'deposits' => $deposits
        ];
        $this->view('admin/manual_deposits', $data, true);
    }

    public function approve_deposit($id) {
        $deposit = $this->manualDepositModel->getDepositById($id);
        if ($deposit) {
            // Update deposit status
            $this->manualDepositModel->updateDepositStatus($id, 'approved');
            // Credit user wallet
            $this->userModel->updateWalletBalance($deposit->user_id, $deposit->amount, 'add');
        }
        redirect('admin/manual_deposits');
    }

    public function reject_deposit($id) {
        $this->manualDepositModel->updateDepositStatus($id, 'rejected');
        redirect('admin/manual_deposits');
    }

    // Overriding the view method to load the admin layout
    public function view($view, $data = [], $isAdmin = false) {
        if ($isAdmin) {
            // Check for view file
            if (file_exists('../app/views/' . $view . '.php')) {
                require_once '../app/views/admin/layout.php';
            } else {
                // View does not exist
                die('View does not exist');
            }
        } else {
            parent::view($view, $data);
        }
    }
}
