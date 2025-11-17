<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostBill - Admin Setup</title>
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
            <h1>Administrator Setup</h1>
        </div>
        <div class="installer-content">
            <p class="lead">Create your administrator account.</p>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Here you would process the form, create the admin user
                // and then redirect to the final step.
                header('Location: ?step=4');
                exit;
            }
            ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="admin_email" class="form-label">Admin Email</label>
                    <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                </div>
                <div class="mb-3">
                    <label for="admin_password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                </div>
                <div class="mb-3">
                    <label for="admin_password_confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="admin_password_confirm" name="admin_password_confirm" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Create Admin & Continue</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
