<?php
// app/views/admin/manage_currencies.php

include BASE_PATH . '/app/views/templates/header.php';
?>

<div class="container mt-5">
    <h2>Manage Currencies & Conversion Rates</h2>
    <p>Configure the currencies and conversion rates for your application.</p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Settings updated successfully.</div>
    <?php endif; ?>

    <form action="/index.php?page=admin_currencies" method="post">
        <div class="card mb-4">
            <div class="card-header">Base Currency</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="base_currency" class="form-label">Select Base Currency</label>
                    <select class="form-select" id="base_currency" name="base_currency">
                        <?php foreach ($currencies as $currency): ?>
                            <option value="<?php echo $currency['code']; ?>" <?php if ($settings['base_currency'] == $currency['code']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($currency['name']); ?> (<?php echo htmlspecialchars($currency['code']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Conversion Rates</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="usd_conversion_rate" class="form-label">USD Conversion Rate (1 USD = ? NGN)</label>
                    <input type="number" class="form-control" id="usd_conversion_rate" name="usd_conversion_rate" step="0.01" value="<?php echo htmlspecialchars($settings['usd_conversion_rate']); ?>">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php
include BASE_PATH . '/app/views/templates/footer.php';
?>
