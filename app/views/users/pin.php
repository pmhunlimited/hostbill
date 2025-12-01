<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Enter Security PIN</h2>
            <p>Please enter your security PIN to continue</p>
            <form action="<?php echo URLROOT; ?>/users/pin" method="post">
                <div class="form-group">
                    <label for="pin">PIN: <sup>*</sup></label>
                    <input type="password" name="pin" class="form-control form-control-lg <?php echo (!empty($data['pin_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['pin']; ?>">
                    <span class="invalid-feedback"><?php echo $data['pin_err']; ?></span>
                </div>
                <?php csrf_input(); ?>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Submit" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
