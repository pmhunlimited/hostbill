<?php
class Users extends Controller {
    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function register() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!validate_csrf_token($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'pin' => trim($_POST['pin']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'pin_err' => ''
            ];

            // Validate data
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            if (empty($data['pin'])) {
                $data['pin_err'] = 'Please enter a security pin';
            }

            // Make sure errors are empty
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['pin_err'])) {
                // Validated
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $data['pin'] = password_hash($data['pin'], PASSWORD_DEFAULT);

                // Register User
                if ($this->userModel->register($data)) {
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }
        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'pin' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'pin_err' => ''
            ];
            // Load view
            $this->view('users/register', $data);
        }
    }

    public function login() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!validate_csrf_token($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate data
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'No user found';
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            // Load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('dashboard');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    public function pin() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!validate_csrf_token($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $data = [
                'pin' => trim($_POST['pin']),
                'pin_err' => ''
            ];

            // Validate data
            if (empty($data['pin'])) {
                $data['pin_err'] = 'Please enter your security pin';
            }

            // Make sure errors are empty
            if (empty($data['pin_err'])) {
                // Validated
                // Check pin
                $user = $this->userModel->getUserById($_SESSION['user_id']);
                if (password_verify($data['pin'], $user->pin)) {
                    $_SESSION['pin_verified'] = true;
                    redirect('dashboard');
                } else {
                    $data['pin_err'] = 'Pin incorrect';
                    $this->view('users/pin', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/pin', $data);
            }
        } else {
            // Init data
            $data = [
                'pin' => '',
                'pin_err' => ''
            ];
            // Load view
            $this->view('users/pin', $data);
        }
    }

    public function forgot_password() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $email = trim($_POST['email']);

            if ($this->userModel->findUserByEmail($email)) {
                $token = bin2hex(random_bytes(32));
                $this->userModel->createPasswordResetToken($email, $token);

                $reset_link = URLROOT . '/users/reset_password/' . $token;
                $subject = 'Password Reset';
                $body = 'Please click this link to reset your password: <a href="' . $reset_link . '">' . $reset_link . '</a>';

                if (send_email($email, $subject, $body)) {
                    flash('password_reset', 'Password reset link has been sent to your email.');
                } else {
                    flash('password_reset', 'Could not send email. Please contact support.', 'alert alert-danger');
                }
            } else {
                flash('password_reset', 'No user found with that email.', 'alert alert-danger');
            }
            redirect('users/forgot_password');
        } else {
            $this->view('users/forgot_password');
        }
    }

    public function reset_password($token = '') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $token = $_POST['token'];
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            $reset_data = $this->userModel->getPasswordResetToken($token);

            if ($reset_data) {
                if ($password === $confirm_password) {
                    $user = $this->userModel->getUserByEmail($reset_data->email);
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $this->userModel->updatePassword($user->id, $hashed_password);
                    $this->userModel->deletePasswordResetToken($reset_data->email);
                    flash('login_success', 'Password has been reset. You can now log in.');
                    redirect('users/login');
                } else {
                    flash('password_reset', 'Passwords do not match.', 'alert alert-danger');
                    redirect('users/reset_password/' . $token);
                }
            } else {
                flash('password_reset', 'Invalid or expired token.', 'alert alert-danger');
                redirect('users/reset_password');
            }
        } else {
            if ($token) {
                $reset_data = $this->userModel->getPasswordResetToken($token);
                if ($reset_data) {
                    $this->view('users/reset_password', ['token' => $token]);
                } else {
                    flash('password_reset', 'Invalid or expired token.', 'alert alert-danger');
                    redirect('users/forgot_password');
                }
            } else {
                redirect('users/forgot_password');
            }
        }
    }

    public function change_pin() {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'current_pin' => trim($_POST['current_pin']),
                'new_pin' => trim($_POST['new_pin']),
                'confirm_new_pin' => trim($_POST['confirm_new_pin']),
                'current_pin_err' => '',
                'new_pin_err' => '',
                'confirm_new_pin_err' => ''
            ];

            $user = $this->userModel->getUserById($_SESSION['user_id']);

            if (password_verify($data['current_pin'], $user->pin)) {
                if ($data['new_pin'] === $data['confirm_new_pin']) {
                    $hashed_pin = password_hash($data['new_pin'], PASSWORD_DEFAULT);
                    $this->userModel->updatePin($_SESSION['user_id'], $hashed_pin);
                    flash('pin_change_success', 'PIN changed successfully.');
                    redirect('dashboard');
                } else {
                    $data['confirm_new_pin_err'] = 'New PINs do not match.';
                    $this->view('users/change_pin', $data);
                }
            } else {
                $data['current_pin_err'] = 'Incorrect current PIN.';
                $this->view('users/change_pin', $data);
            }
        } else {
            $this->view('users/change_pin');
        }
    }
}
