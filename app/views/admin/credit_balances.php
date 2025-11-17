<?php
// app/views/admin/credit_balances.php

include BASE_PATH . '/app/views/templates/header.php';
?>

<div class="container mt-5">
    <h2>Client Credit Balances</h2>
    <p>This page displays the credit balances for all clients.</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Email</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['email']); ?></td>
                    <td>$<?php echo number_format($client['balance'] ?? 0.00, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include BASE_PATH . '/app/views/templates/footer.php';
?>
