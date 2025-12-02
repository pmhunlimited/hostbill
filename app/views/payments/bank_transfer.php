<?php require APPROOT . '/views/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Bank Transfer</h2>
            <p>Please transfer the amount of N<?php echo $data['amount']; ?> to the following bank account:</p>
            <ul class="list-group">
                <li class="list-group-item"><strong>Bank Name:</strong> Wema Bank</li>
                <li class="list-group-item"><strong>Account Number:</strong> 6641725267</li>
                <li class="list-group-item"><strong>Account Name:</strong> BardePay</li>
            </ul>
            <p class="mt-3">After making the transfer, please fill out the form below to notify us.</p>
            <form action="<?php echo URLROOT; ?>/payments/notify" method="post" enctype="multipart/form-data">
                <input type="hidden" name="amount" value="<?php echo $data['amount']; ?>">
                <?php csrf_input(); ?>
                <div class="form-group">
                    <label for="sender_name">Sender Name: <sup>*</sup></label>
                    <input type="text" name="sender_name" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label for="proof">Proof of Payment: <sup>*</sup></label>
                    <input type="file" name="proof" class="form-control-file">
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Notify" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/footer.php'; ?>
