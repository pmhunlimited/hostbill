<?php
// app/views/admin/manual_approvals.php

include BASE_PATH . '/app/views/templates/header.php';
?>

<div class="container mt-5">
    <h2>Manual Payment Approvals</h2>
    <p>Review and approve payments made via manual gateways.</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Gateway</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pending_transactions as $transaction): ?>
                <tr>
                    <td><?php echo $transaction['id']; ?></td>
                    <td><?php echo htmlspecialchars($transaction['username']); ?></td>
                    <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($transaction['gateway']); ?></td>
                    <td><?php echo $transaction['date']; ?></td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm">Approve</a>
                        <a href="#" class="btn btn-danger btn-sm">Reject</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include BASE_PATH . '/app/views/templates/footer.php';
?>
