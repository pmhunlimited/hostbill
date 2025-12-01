<?php
class Payments extends Controller {
    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        // Check if pin is verified
        if (!isset($_SESSION['pin_verified'])) {
            redirect('users/pin');
        }

        $this->paymentModel = $this->model('Payment');
        $this->userModel = $this->model('User');
        $this->manualDepositModel = $this->model('ManualDeposit');
    }

    public function index() {
        $this->view('payments/index');
    }

    public function fund() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $amount = trim($_POST['amount']);
            $gateway = trim($_POST['gateway']);
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $tx_ref = 'VTU-' . uniqid();

            // Store transaction details in session to verify on callback
            $_SESSION['payment_details'] = [
                'amount' => $amount,
                'tx_ref' => $tx_ref
            ];

            if ($gateway == 'flutterwave') {
                $this->initiateFlutterwavePayment($amount, $user, $tx_ref);
            } elseif ($gateway == 'paystack') {
                $this->initiatePaystackPayment($amount, $user, $tx_ref);
            } elseif ($gateway == 'bank_transfer') {
                $this->view('payments/bank_transfer', ['amount' => $amount]);
            } else {
                redirect('payments');
            }
        } else {
            $this->view('payments/index');
        }
    }

    public function notify() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $amount = trim($_POST['amount']);

            // Handle file upload
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["proof"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["proof"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["proof"]["size"] > 500000) {
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
                    $this->manualDepositModel->addDeposit($_SESSION['user_id'], $amount, $target_file);
                    flash('deposit_notification', 'Your deposit notification has been sent. Please wait for approval.');
                    redirect('dashboard');
                }
            }
        }
        $this->view('payments/bank_transfer');
    }


    private function initiateFlutterwavePayment($amount, $user, $tx_ref) {
        // Get Flutterwave keys from settings
        $flutterwave_keys = $this->paymentModel->getGatewaySettings('flutterwave');
        $public_key = $flutterwave_keys['public_key'];
        $secret_key = $flutterwave_keys['secret_key'];

        $redirect_url = URLROOT . '/payments/verify_flutterwave';

        $payment_data = [
            'tx_ref' => $tx_ref,
            'amount' => $amount,
            'currency' => 'NGN',
            'redirect_url' => $redirect_url,
            'customer' => [
                'email' => $user->email,
                'name' => $user->name
            ],
            'customizations' => [
                'title' => SITENAME . ' Wallet Funding',
                'description' => 'Funding wallet for ' . $user->name,
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payment_data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $secret_key,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($response);
        if ($res->status == 'success') {
            header('Location: ' . $res->data->link);
        } else {
            die('Error: Could not initiate payment.');
        }
    }

    public function verify_flutterwave() {
        if (isset($_GET['status']) && isset($_GET['tx_ref']) && isset($_GET['transaction_id'])) {
            $tx_ref = $_GET['tx_ref'];
            $transaction_id = $_GET['transaction_id'];
            $payment_details = $_SESSION['payment_details'];

            if ($tx_ref == $payment_details['tx_ref']) {
                $flutterwave_keys = $this->paymentModel->getGatewaySettings('flutterwave');
                $secret_key = $flutterwave_keys['secret_key'];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$transaction_id}/verify",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                      "Content-Type: application/json",
                      "Authorization: Bearer " . $secret_key
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                $res = json_decode($response);
                if($res->status == "success" && $res->data->amount == $payment_details['amount'] && $res->data->status == "successful"){
                    // Payment is successful
                    $this->paymentModel->creditUserWallet($_SESSION['user_id'], $payment_details['amount']);
                    $this->paymentModel->logPayment($_SESSION['user_id'], $payment_details['amount'], $tx_ref, 'Flutterwave', 'Success');
                    unset($_SESSION['payment_details']);
                    redirect('dashboard'); // Redirect to a success page
                } else {
                    // Payment failed
                     $this->paymentModel->logPayment($_SESSION['user_id'], $payment_details['amount'], $tx_ref, 'Flutterwave', 'Failed');
                    unset($_SESSION['payment_details']);
                    die('Payment verification failed.');
                }
            }
        } else {
            redirect('dashboard');
        }
    }


    private function initiatePaystackPayment($amount, $user, $tx_ref) {
        $paystack_keys = $this->paymentModel->getGatewaySettings('paystack');
        $secret_key = $paystack_keys['secret_key'];

        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
            'email' => $user->email,
            'amount' => $amount * 100, // Paystack expects amount in kobo
            'reference' => $tx_ref,
            'callback_url' => URLROOT . '/payments/verify_paystack'
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $secret_key,
            "Cache-Control: no-cache",
        ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($result);
        if ($res->status) {
            header('Location: ' . $res->data->authorization_url);
        } else {
            die('Error: Could not initiate payment.');
        }
    }

    public function verify_paystack() {
        if (isset($_GET['reference'])) {
            $reference = $_GET['reference'];
            $payment_details = $_SESSION['payment_details'];

            if ($reference == $payment_details['tx_ref']) {
                $paystack_keys = $this->paymentModel->getGatewaySettings('paystack');
                $secret_key = $paystack_keys['secret_key'];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        "accept: application/json",
                        "authorization: Bearer " . $secret_key,
                        "cache-control: no-cache"
                    ],
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                $res = json_decode($response);
                if ($res->status && $res->data->status == 'success' && $res->data->amount == ($payment_details['amount'] * 100)) {
                    // Payment is successful
                    $this->paymentModel->creditUserWallet($_SESSION['user_id'], $payment_details['amount']);
                    $this->paymentModel->logPayment($_SESSION['user_id'], $payment_details['amount'], $reference, 'Paystack', 'Success');
                    unset($_SESSION['payment_details']);
                    redirect('dashboard'); // Redirect to a success page
                } else {
                    // Payment failed
                    $this->paymentModel->logPayment($_SESSION['user_id'], $payment_details['amount'], $reference, 'Paystack', 'Failed');
                    unset($_SESSION['payment_details']);
                    die('Payment verification failed.');
                }
            }
        } else {
            redirect('dashboard');
        }
    }
}
