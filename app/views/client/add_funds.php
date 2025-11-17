<?php
// app/views/client/add_funds.php

include BASE_PATH . '/app/views/templates/header.php';
?>

<div class="container mt-5">
    <h2>Add Funds</h2>
    <p>Here you can add funds to your account balance. These funds can be used to pay for new orders or renew existing services.</p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Funds added successfully!</div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Current Balance</h5>
            <p class="card-text display-4">$<?php echo number_format($credit_balance, 2); ?></p>
        </div>
    </div>

    <form action="/index.php?page=add_funds" method="post">
        <div class="mb-3">
            <label for="amount" class="form-label">Amount to Add</label>
            <input type="number" class="form-control" id="amount" name="amount" min="1.00" step="0.01" required>
        </div>

        <h5>Select Payment Method</h5>
        <?php foreach ($gateways as $gateway): ?>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment_gateway" id="gateway_<?php echo $gateway['id']; ?>" value="<?php echo $gateway['name']; ?>" required>
          <label class="form-check-label" for="gateway_<?php echo $gateway['id']; ?>">
            <?php echo htmlspecialchars($gateway['display_name']); ?>
          </label>
        </div>
        <div class="alert alert-info" id="instructions_<?php echo $gateway['name']; ?>" style="display: none;">
            <?php echo nl2br(htmlspecialchars($gateway['instructions'])); ?>
        </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary mt-3">Add Funds</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gateways = document.querySelectorAll('input[name="payment_gateway"]');
    gateways.forEach(gateway => {
        gateway.addEventListener('change', function() {
            const instructions = document.querySelectorAll('.alert-info');
            instructions.forEach(instruction => {
                instruction.style.display = 'none';
            });
            if (this.checked) {
                const instructionId = 'instructions_' + this.value;
                document.getElementById(instructionId).style.display = 'block';
            }
        });
    });
});
</script>

<?php
include BASE_PATH . '/app/views/templates/footer.php';
?>
