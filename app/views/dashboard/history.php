<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="transaction-history">
    <h2>Transaction History</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['transactions'] as $transaction) : ?>
                <tr>
                    <td><?php echo $transaction->id; ?></td>
                    <td><?php echo $transaction->service; ?></td>
                    <td>&#8358;<?php echo number_format($transaction->amount, 2); ?></td>
                    <td><?php echo $transaction->status; ?></td>
                    <td><?php echo $transaction->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
