<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostBill - Welcome</title>
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
        .requirement-list {
            list-style: none;
            padding: 0;
        }
        .requirement-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }
        .requirement-list li:last-child {
            border-bottom: none;
        }
        .badge {
            font-size: 0.9rem;
            padding: 0.4em 0.6em;
        }
    </style>
</head>
<body>
    <div class="installer-container">
        <div class="installer-header">
            <h1>Welcome to HostBill</h1>
        </div>
        <div class="installer-content">
            <p class="lead">This wizard will guide you through the installation process. First, let's check your server requirements.</p>

            <?php
            $requirements = [
                'php_version' => [
                    'label' => 'PHP Version >= 8.0',
                    'check' => version_compare(PHP_VERSION, '8.0.0', '>='),
                ],
                'mysqli' => [
                    'label' => 'MySQLi Extension',
                    'check' => extension_loaded('mysqli'),
                ],
                'curl' => [
                    'label' => 'cURL Extension',
                    'check' => extension_loaded('curl'),
                ],
                'openssl' => [
                    'label' => 'OpenSSL Extension',
                    'check' => extension_loaded('openssl'),
                ],
            ];

            $all_ok = true;
            ?>

            <ul class="requirement-list my-4">
                <?php foreach ($requirements as $key => $req): ?>
                    <?php
                    if (!$req['check']) {
                        $all_ok = false;
                    }
                    ?>
                    <li>
                        <span><?php echo $req['label']; ?></span>
                        <?php if ($req['check']): ?>
                            <span class="badge bg-success">OK</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Failed</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if ($all_ok): ?>
                <p class="text-success">Congratulations! Your server meets all the requirements.</p>
                <div class="d-grid">
                    <a href="?step=2" class="btn btn-primary btn-lg">Continue to Step 2</a>
                </div>
            <?php else: ?>
                <p class="text-danger">Your server does not meet the minimum requirements. Please resolve the issues above before continuing.</p>
                <div class="d-grid">
                     <button class="btn btn-primary btn-lg" disabled>Cannot Continue</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
