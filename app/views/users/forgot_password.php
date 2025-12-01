<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Forgot Password</h2>
            <?php flash('password_reset'); ?>
            <p>Please enter your email address to receive a password reset link.</p>
            <form action="<?php echo URLROOT; ?>/users/forgot_password" method="post">
                <?php csrf_input(); ?>
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg">
                </div>
                <input type="submit" value="Send Reset Link" class="btn btn-success btn-block">
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
