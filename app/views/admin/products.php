<?php
// app/views/admin/products.php
include BASE_PATH . '/templates/header.php';
?>

<div class="card">
    <div class="card-body">
        <h1 class="card-title">Manage Products</h1>

        <!-- Add New Product Form -->
        <div class="mb-4">
            <h4>Add New Product</h4>
            <form method="POST" action="?page=admin_products&action=add">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price_monthly" class="form-label">Monthly Price</label>
                        <input type="number" step="0.01" class="form-control" id="price_monthly" name="price_monthly" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price_annually" class="form-label">Annual Price</label>
                        <input type="number" step="0.01" class="form-control" id="price_annually" name="price_annually" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>

        <!-- Product List -->
        <h4>Existing Products</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Monthly Price</th>
                    <th>Annual Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                        <td>$<?php echo htmlspecialchars($product['price_monthly']); ?></td>
                        <td>$<?php echo htmlspecialchars($product['price_annually']); ?></td>
                        <td>
                            <a href="?page=admin_products&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                            <a href="?page=admin_products&action=delete&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include BASE_PATH . '/templates/footer.php';
