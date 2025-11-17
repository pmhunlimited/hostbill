<?php
// app/views/admin/manage_gateways.php

include BASE_PATH . '/app/views/templates/header.php';
?>

<div class="container mt-5">
    <h2>Manage Payment Gateways</h2>
    <p>Configure the payment gateways available to clients.</p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Payment gateways updated successfully.</div>
    <?php endif; ?>

    <form action="/index.php?page=admin_gateways" method="post">
        <input type="hidden" name="update_gateways" value="1">
        <?php foreach ($gateways as $gateway): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="gateway_enabled_<?php echo $gateway['id']; ?>" name="gateways[<?php echo $gateway['id']; ?>][is_enabled]" <?php if ($gateway['is_enabled']) echo 'checked'; ?>>
                        <label class="form-check-label" for="gateway_enabled_<?php echo $gateway['id']; ?>"><?php echo htmlspecialchars($gateway['name']); ?></label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="gateway_display_name_<?php echo $gateway['id']; ?>" class="form-label">Display Name</label>
                        <input type="text" class="form-control" id="gateway_display_name_<?php echo $gateway['id']; ?>" name="gateways[<?php echo $gateway['id']; ?>][display_name]" value="<?php echo htmlspecialchars($gateway['display_name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="gateway_instructions_<?php echo $gateway['id']; ?>" class="form-label">Payment Instructions</label>
                        <textarea class="form-control" id="gateway_instructions_<?php echo $gateway['id']; ?>" name="gateways[<?php echo $gateway['id']; ?>][instructions]" rows="4"><?php echo htmlspecialchars($gateway['instructions']); ?></textarea>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php
include BASE_PATH . '/app/views/templates/footer.php';
?>
