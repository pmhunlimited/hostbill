<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Reset Password</h2>
            <?php flash('password_reset'); ?>
            <form action="<?php echo URLROOT; ?>/users/reset_password" method="post">
                <?php csrf_input(); ?>
                <input type="hidden" name="token" value="<?php echo $data['token']; ?>">
                <div class="form-group">
                    <label for="password">New Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg">
                </div>
                <input type="submit" value="Reset Password" class="btn btn-success btn-block">
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
