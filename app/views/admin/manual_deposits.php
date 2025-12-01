<div class="admin-manual-deposits">
    <h2>Manual Deposits</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Proof</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['deposits'] as $deposit) : ?>
                <tr>
                    <td><?php echo $deposit->id; ?></td>
                    <td><?php echo $deposit->email; ?></td>
                    <td>&#8358;<?php echo number_format($deposit->amount, 2); ?></td>
                    <td><a href="<?php echo URLROOT . '/' . $deposit->proof; ?>" target="_blank">View Proof</a></td>
                    <td><?php echo $deposit->status; ?></td>
                    <td><?php echo $deposit->created_at; ?></td>
                    <td>
                        <a href="<?php echo URLROOT; ?>/admin/approve_deposit/<?php echo $deposit->id; ?>">Approve</a>
                        <a href="<?php echo URLROOT; ?>/admin/reject_deposit/<?php echo $deposit->id; ?>">Reject</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
