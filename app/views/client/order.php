<?php
// app/views/client/order.php
include BASE-PATH . '/templates/header.php';
?>

<div class="card">
    <div class="card-body">
        <h1 class="card-title">Order New Service</h1>
        <p class="lead">Browse our products and services below.</p>

        <?php foreach ($categories as $category): ?>
            <div class="mb-4">
                <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                <p><?php echo htmlspecialchars($category['description']); ?></p>

                <div class="row">
                    <?php if (isset($products_by_category[$category['id']])): ?>
                        <?php foreach ($products_by_category[$category['id']] as $product): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                        <div class="mt-auto">
                                            <p class="h4">$<?php echo htmlspecialchars($product['price_monthly']); ?>/mo</p>
                                            <a href="#" class="btn btn-primary">Order Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products in this category yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
include BASE_PATH . '/templates/footer.php';
