<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostBill - Database Configuration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .installer-container {
            max-width: 600px;
            margin: 5rem auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .installer-header {
            background-color: #6c5ce7;
            color: #fff;
            padding: 2rem;
            text-align: center;
        }
        .installer-header h1 {
            margin: 0;
            font-weight: 300;
        }
        .installer-content {
            padding: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="installer-container">
        <div class="installer-header">
            <h1>Database Configuration</h1>
        </div>
        <div class="installer-content">
            <p class="lead">Please provide your database connection details below.</p>

            <?php
            $error_message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $db_host = $_POST['db_host'];
                $db_user = $_POST['db_user'];
                $db_pass = $_POST['db_pass'];
                $db_name = $_POST['db_name'];

                // Attempt to connect
                $conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);

                if ($conn->connect_error) {
                    $error_message = 'Connection failed: ' . $conn->connect_error;
                } else {
                    // Connection successful
                    // Here you would save the config and proceed
                    header('Location: ?step=3');
                    exit;
                }
            }
            ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="db_host" class="form-label">Database Host</label>
                    <input type="text" class="form-control" id="db_host" name="db_host" required>
                </div>
                <div class="mb-3">
                    <label for="db_name" class="form-label">Database Name</label>
                    <input type="text" class="form-control" id="db_name" name="db_name" required>
                </div>
                <div class="mb-3">
                    <label for="db_user" class="form-label">Database User</label>
                    <input type="text" class="form-control" id="db_user" name="db_user" required>
                </div>
                <div class="mb-3">
                    <label for="db_pass" class="form-label">Database Password</label>
                    <input type="password" class="form-control" id="db_pass" name="db_pass">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Test Connection & Continue</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
