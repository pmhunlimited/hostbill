<div class="admin-users">
    <h2>Manage Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Wallet Balance</th>
                <th>Bonus Balance</th>
                <th>Is Admin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['users'] as $user) : ?>
                <tr>
                    <td><?php echo $user->id; ?></td>
                    <td><?php echo $user->name; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td>&#8358;<?php echo number_format($user->wallet_balance, 2); ?></td>
                    <td>&#8358;<?php echo number_format($user->bonus_balance, 2); ?></td>
                    <td><?php echo $user->is_admin ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="<?php echo URLROOT; ?>/admin/edit_user/<?php echo $user->id; ?>">Edit</a>
                        <a href="<?php echo URLROOT; ?>/admin/login_as_user/<?php echo $user->id; ?>" target="_blank">Login As</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
