<div class="admin-edit-user">
    <h2>Edit User</h2>
    <form action="<?php echo URLROOT; ?>/admin/edit_user/<?php echo $data['user']->id; ?>" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $data['user']->name; ?>">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $data['user']->email; ?>">
        </div>
        <div>
            <label for="wallet_balance">Wallet Balance:</label>
            <input type="text" name="wallet_balance" id="wallet_balance" value="<?php echo $data['user']->wallet_balance; ?>">
        </div>
        <div>
            <label for="bonus_balance">Bonus Balance:</label>
            <input type="text" name="bonus_balance" id="bonus_balance" value="<?php echo $data['user']->bonus_balance; ?>">
        </div>
        <div>
            <label for="is_admin">Is Admin:</label>
            <input type="checkbox" name="is_admin" id="is_admin" <?php echo $data['user']->is_admin ? 'checked' : ''; ?>>
        </div>
        <?php csrf_input(); ?>
        <button type="submit">Update</button>
    </form>
</div>
