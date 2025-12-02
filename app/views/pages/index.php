<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/landing.css">

<header class="hero-section">
    <div class="hero-content">
        <h1>Welcome to <?php echo SITENAME; ?></h1>
        <p>Your one-stop solution for instant data top-ups.</p>
        <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-primary btn-lg">Get Started</a>
    </div>
</header>

<section id="features" class="features-section">
    <div class="container">
        <h2>Features</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-item">
                    <i class="fas fa-bolt"></i>
                    <h3>Instant Delivery</h3>
                    <p>Get your data bundles delivered instantly, anytime.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure Payments</h3>
                    <p>All your transactions are secured with industry-standard encryption.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item">
                    <i class="fas fa-headset"></i>
                    <h3>24/7 Support</h3>
                    <p>Our support team is available around the clock to assist you.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="about-section">
    <div class="container">
        <h2>About Us</h2>
        <p>We are a team of dedicated professionals committed to providing you with the best and most affordable data services in the market. Our platform is designed to be user-friendly, reliable, and secure.</p>
    </div>
</section>

<section id="contact" class="contact-section">
    <div class="container">
        <h2>Contact Us</h2>
        <p>Have any questions? We'd love to hear from you. Reach out to us at <a href="mailto:support@<?php echo strtolower(SITENAME); ?>.com">support@<?php echo strtolower(SITENAME); ?>.com</a></p>
    </div>
</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>
