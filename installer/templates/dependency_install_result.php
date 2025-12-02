<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Installing Dependencies</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="installer-header">
            <h1>Installing Dependencies</h1>
        </div>
        <div class="content">
            <?php if ($install_error): ?>
                <h2>Installation Failed</h2>
                <p class="error">The installer tried to run <code>composer install</code>, but it failed. Please review the output below for errors.</p>
                <p>You may need to run the command manually from your terminal. Once the dependencies are installed, you can refresh this page to continue.</p>
            <?php else: ?>
                <h2>Installation Complete</h2>
                <p>The required dependencies have been successfully installed.</p>
                <a href="index.php" class="button">Continue Installation</a>
            <?php endif; ?>

            <h3>Composer Output:</h3>
            <pre class="output"><?php echo htmlspecialchars($composer_output, ENT_QUOTES, 'UTF-8'); ?></pre>
        </div>
    </div>
</body>
</html>
