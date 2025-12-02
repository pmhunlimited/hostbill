<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Change PIN</h2>
            <?php flash('pin_change_success'); ?>
            <form action="<?php echo URLROOT; ?>/users/change_pin" method="post">
                <?php csrf_input(); ?>
                <div class="form-group">
                    <label for="current_pin">Current PIN: <sup>*</sup></label>
                    <input type="password" name="current_pin" class="form-control form-control-lg <?php echo (!empty($data['current_pin_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $data['current_pin_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="new_pin">New PIN: <sup>*</sup></label>
                    <input type="password" name="new_pin" class="form-control form-control-lg <?php echo (!empty($data['new_pin_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $data['new_pin_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_new_pin">Confirm New PIN: <sup>*</sup></label>
                    <input type="password" name="confirm_new_pin" class="form-control form-control-lg <?php echo (!empty($data['confirm_new_pin_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $data['confirm_new_pin_err']; ?></span>
                </div>
                <input type="submit" value="Change PIN" class="btn btn-success btn-block">
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
