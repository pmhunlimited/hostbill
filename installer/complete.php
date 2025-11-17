<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostBill - Installation Complete</title>
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
            background-color: #28a745;
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
            <h1>Installation Complete</h1>
        </div>
        <div class="installer-content">
            <p class="lead">Congratulations! HostBill has been successfully installed.</p>

            <div class="alert alert-warning mt-4">
                <h4>Security Warning!</h4>
                <p>For security reasons, please delete the <strong>installer</strong> directory from your server immediately.</p>
            </div>

            <div class="d-grid mt-4">
                <a href="../public/index.php" class="btn btn-primary btn-lg">Go to Admin Panel</a>
            </div>
        </div>
    </div>
</body>
</html>
