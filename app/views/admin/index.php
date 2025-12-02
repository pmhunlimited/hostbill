<div class="admin-dashboard">
    <h2>Dashboard</h2>
    <div class="stats-cards">
        <div class="card">
            <h4>Total Users</h4>
            <p><?php echo $data['stats']->total_users; ?></p>
        </div>
        <div class="card">
            <h4>Total Transactions</h4>
            <p><?php echo $data['stats']->total_transactions; ?></p>
        </div>
        <div class="card">
            <h4>Total Revenue</h4>
            <p>&#8358;<?php echo number_format($data['stats']->total_revenue, 2); ?></p>
        </div>
    </div>

    <h3>Recent Transactions</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Service</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['recent_transactions'] as $transaction) : ?>
                <tr>
                    <td><?php echo $transaction->id; ?></td>
                    <td><?php echo $transaction->user_email; ?></td>
                    <td><?php echo $transaction->service; ?></td>
                    <td>&#8358;<?php echo number_format($transaction->amount, 2); ?></td>
                    <td><?php echo $transaction->status; ?></td>
                    <td><?php echo $transaction->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
