<?php
// Check PHP version
$php_version = phpversion();
$required_php_version = '7.4';
$php_version_ok = version_compare($php_version, $required_php_version, '>=');

// Check for required extensions
$required_extensions = ['pdo_mysql', 'curl', 'openssl'];
$extensions_ok = true;
foreach ($required_extensions as $extension) {
    if (!extension_loaded($extension)) {
        $extensions_ok = false;
    }
}
?>

<h1 class="mb-4">Welcome to the VTU Installer</h1>
<p>This wizard will guide you through the installation of the VTU script.</p>

<div class="card mb-4">
    <div class="card-header">
        Server Requirements
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            PHP Version (<?php echo $required_php_version; ?>+ required)
            <span class="badge badge-<?php echo $php_version_ok ? 'success' : 'danger'; ?>">
                <?php echo $php_version; ?>
            </span>
        </li>
        <?php foreach ($required_extensions as $extension) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo ucfirst($extension); ?> Extension
                <span class="badge badge-<?php echo extension_loaded($extension) ? 'success' : 'danger'; ?>">
                    <?php echo extension_loaded($extension) ? 'Enabled' : 'Disabled'; ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php if ($php_version_ok && $extensions_ok) : ?>
    <a href="index.php?stage=2" class="btn btn-primary">Next</a>
<?php else : ?>
    <div class="alert alert-danger">
        Please fix the issues above before proceeding.
    </div>
<?php endif; ?>
