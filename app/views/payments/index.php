<?php require APPROOT . '/views/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Fund Wallet</h2>
            <p>Please enter the amount you want to fund and choose a payment gateway</p>
            <form action="<?php echo URLROOT; ?>/payments/fund" method="post">
                <div class="form-group">
                    <label for="amount">Amount: <sup>*</sup></label>
                    <input type="number" name="amount" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label for="gateway">Payment Gateway: <sup>*</sup></label>
                    <select name="gateway" class="form-control form-control-lg">
                        <option value="flutterwave">Flutterwave</option>
                        <option value="paystack">Paystack</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Fund" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/footer.php'; ?>
