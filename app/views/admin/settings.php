<div class="admin-settings">
    <h2>Settings</h2>
    <form action="<?php echo URLROOT; ?>/admin/settings" method="post">
        <div>
            <label for="flutterwave_public_key">Flutterwave Public Key:</label>
            <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" value="<?php echo $data['settings']->flutterwave_public_key; ?>">
        </div>
        <div>
            <label for="flutterwave_secret_key">Flutterwave Secret Key:</label>
            <input type="text" name="flutterwave_secret_key" id="flutterwave_secret_key" value="<?php echo $data['settings']->flutterwave_secret_key; ?>">
        </div>
        <div>
            <label for="paystack_public_key">Paystack Public Key:</label>
            <input type="text" name="paystack_public_key" id="paystack_public_key" value="<?php echo $data['settings']->paystack_public_key; ?>">
        </div>
        <div>
            <label for="paystack_secret_key">Paystack Secret Key:</label>
            <input type="text" name="paystack_secret_key" id="paystack_secret_key" value="<?php echo $data['settings']->paystack_secret_key; ?>">
        </div>
        <div>
            <label for="api_key">Data Bundle API Key:</label>
            <input type="text" name="api_key" id="api_key" value="<?php echo $data['settings']->api_key; ?>">
        </div>
        <hr>
        <h3>SMTP Settings</h3>
        <div>
            <label for="smtp_host">SMTP Host:</label>
            <input type="text" name="smtp_host" id="smtp_host" value="<?php echo $data['settings']->smtp_host; ?>">
        </div>
        <div>
            <label for="smtp_user">SMTP User:</label>
            <input type="text" name="smtp_user" id="smtp_user" value="<?php echo $data['settings']->smtp_user; ?>">
        </div>
        <div>
            <label for="smtp_pass">SMTP Password:</label>
            <input type="password" name="smtp_pass" id="smtp_pass" value="<?php echo $data['settings']->smtp_pass; ?>">
        </div>
        <div>
            <label for="smtp_port">SMTP Port:</label>
            <input type="text" name="smtp_port" id="smtp_port" value="<?php echo $data['settings']->smtp_port; ?>">
        </div>
        <?php csrf_input(); ?>
        <button type="submit">Save Settings</button>
    </form>
</div>
