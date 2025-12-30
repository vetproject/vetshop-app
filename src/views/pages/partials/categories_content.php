<?php
require_once __DIR__ . '/../../../models/categoryModel.php';
$deleteCategory = deleteCategory($_GET['id'] ?? null);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .form-additional-search {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .form-additional-search input {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }
</style>

<div class="form-additional-search">
    <input type="text" id="searchInput" placeholder="Search categories...">

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fa fa-plus"></i> Add Category
    </button>
</div>

<!-- ADD CATEGORY MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <form action="../../../controllers/add_category.php" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- UPDATE CATEGORY MODAL -->
<div class="modal fade" id="updateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <form action="../../../controllers/update_category.php" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Update Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="updateCategoryId">

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" id="updateCategoryName" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="updateCategoryDescription"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- CATEGORY TABLE -->
<table class="table">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>DESCRIPTION</th>
            <th>CREATED AT</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody id="categoryTable">
        <?php
        require_once __DIR__ . '/../../../models/categoryModel.php';
        $categories = getAllCategories();

        if (!empty($categories)):
            foreach ($categories as $index => $cat):
        ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><?= htmlspecialchars($cat['description'] ?? 'N/A') ?></td>
                    <td><?= date('Y-m-d', strtotime($cat['created_at'])) ?></td>
                    <td>
                        <a href="edit_category.php?id=<?= $cat['id'] ?>" 
                        class="btn btn-sm btn-warning"
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModal"
                        data-id="<?= $cat['id'] ?>"
                        data-name="<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($cat['description'] ?? '', ENT_QUOTES) ?>"
                        >
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="/categories?id=<?= $cat['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this category?');">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach;
        else: ?>
            <tr>
                <td colspan="4" class="text-center">No categories found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- SEARCH -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#categoryTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
<!-- UPDATE MODAL SCRIPT -->
<script>
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;

        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var description = button.getAttribute('data-description');

        document.getElementById('updateCategoryId').value = id;
        document.getElementById('updateCategoryName').value = name;
        document.getElementById('updateCategoryDescription').value = description;
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>