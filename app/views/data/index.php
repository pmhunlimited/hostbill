<?php require APPROOT . '/views/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Buy Data</h2>
            <p>Please fill out this form to purchase data</p>
            <form action="<?php echo URLROOT; ?>/data/purchase" method="post">
                <div class="form-group">
                    <label for="network">Network: <sup>*</sup></label>
                    <select name="network" class="form-control form-control-lg <?php echo (!empty($data['network_err'])) ? 'is-invalid' : ''; ?>">
                        <option value="mtn">MTN</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $data['network_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="data_plan">Data Plan: <sup>*</sup></label>
                    <select name="data_plan" class="form-control form-control-lg <?php echo (!empty($data['data_plan_err'])) ? 'is-invalid' : ''; ?>">
                        <?php foreach ($data['data_plans'] as $plan) : ?>
                            <option value="<?php echo $plan->plan_id; ?>"><?php echo $plan->name; ?> - N<?php echo $plan->price; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="invalid-feedback"><?php echo $data['data_plan_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number: <sup>*</sup></label>
                    <input type="text" name="phone_number" class="form-control form-control-lg <?php echo (!empty($data['phone_number_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['phone_number']; ?>">
                    <span class="invalid-feedback"><?php echo $data['phone_number_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_phone_number">Confirm Phone Number: <sup>*</sup></label>
                    <input type="text" name="confirm_phone_number" class="form-control form-control-lg <?php echo (!empty($data['confirm_phone_number_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_phone_number']; ?>">
                    <span class="invalid-feedback"><?php echo $data['confirm_phone_number_err']; ?></span>
                </div>
                <?php csrf_input(); ?>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Purchase" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/footer.php'; ?>
