<?php
// app/views/admin/categories.php
include BASE_PATH . '/templates/header.php';
?>

<div class="card">
    <div class="card-body">
        <h1 class="card-title">Manage Product Categories</h1>

        <!-- Add New Category Form -->
        <div class="mb-4">
            <h4>Add New Category</h4>
            <form method="POST" action="?page=admin_categories&action=add">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </form>
        </div>

        <!-- Category List -->
        <h4>Existing Categories</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                        <td><?php echo htmlspecialchars($category['description']); ?></td>
                        <td>
                            <a href="?page=admin_categories&action=edit&id=<?php echo $category['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                            <a href="?page=admin_categories&action=delete&id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include BASE_PATH . '/templates/footer.php';
