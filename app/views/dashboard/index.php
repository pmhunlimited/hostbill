<?php require APPROOT . '/views/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/dashboard.css">

<div class="dashboard-container">
    <div class="dashboard-header">
        <div class="welcome-message">
            <img src="https://i.imgur.com/3g5jA2Q.png" alt="User Avatar" class="avatar">
            <div>
                <p>Welcome Back! 👋</p>
                <strong><?php echo $data['user']->name; ?></strong>
            </div>
        </div>
        <button class="refresh-button">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>

    <div class="wallet-balance-card">
        <div class="balance-info">
            <p>Wallet Balance</p>
            <h2>N<?php echo number_format($data['user']->wallet_balance, 2); ?></h2>
            <p>Bonus Balance: N<?php echo number_format($data['user']->bonus_balance, 2); ?></p>
        </div>
        <div class="wallet-actions">
            <button class="hide-balance-button">
                <i class="fas fa-eye-slash"></i>
            </button>
            <button class="fund-wallet-button">
                <i class="fas fa-plus"></i> Fund Wallet
            </button>
        </div>
    </div>

    <div class="palmpay-card">
        <div class="palmpay-header">
            <span>(BardePay - <?php echo $data['user']->name; ?>)</span>
            <button class="copy-button"><i class="far fa-copy"></i></button>
        </div>
        <div class="palmpay-body">
            <div>
                <p>Palmpay</p>
                <h3>6641725267</h3>
            </div>
            <div class="charge-button">
                Charge N30
            </div>
        </div>
    </div>

    <div class="services-grid">
        <div class="service-icon">
            <i class="fas fa-wifi"></i>
            <span>Data</span>
        </div>
        <div class="service-icon">
            <i class="fas fa-phone-alt"></i>
            <span>Airtime</span>
        </div>
        <div class="service-icon">
            <i class="fas fa-lightbulb"></i>
            <span>Electricity</span>
        </div>
        <div class="service-icon">
            <i class="fas fa-ellipsis-h"></i>
            <span>More</span>
        </div>
    </div>

    <div class="referral-banner">
        <div>
            <h3>Get Rewarded for inviting users!</h3>
            <p>Refer friends to Bardetech and earn referral bonuses!</p>
            <button>View Referrals</button>
        </div>
        <img src="https://i.imgur.com/3g5jA2Q.png" alt="Referral Image">
    </div>

    <div class="recent-transactions">
        <div class="recent-transactions-header">
            <h4>Recent Transactions</h4>
            <a href="<?php echo URLROOT; ?>/dashboard/history">See All &raquo;</a>
        </div>
        <!-- Transaction list will go here -->
    </div>

    <div class="account-actions">
        <a href="<?php echo URLROOT; ?>/users/change_pin">Change PIN</a>
    </div>

    <nav class="bottom-nav">
        <a href="#" class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-list-alt"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-bell"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-user"></i>
        </a>
    </nav>
</div>
<?php require APPROOT . '/views/footer.php'; ?>
