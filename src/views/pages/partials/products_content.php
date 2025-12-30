<?php
require_once __DIR__ . '/../../../models/productModel.php';
$deleteProduct = deleteProduct($_GET['id'] ?? null);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .form-additional-search {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .form-additional-search input[type="text"] {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-additional-search input[type="text"]:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.15);
    }

    .form-additional-search button {
        padding: 10px 18px;
        background-color: #4f46e5;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        white-space: nowrap;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .form-additional-search button:hover {
        background-color: #4338ca;
    }

    .form-additional-search button:active {
        transform: scale(0.98);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .form-additional-search {
            flex-direction: column;
            align-items: stretch;
        }

        .form-additional-search button {
            width: 100%;
        }
    }

    .product-img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
    }
</style>

<div class="form-additional-search">
    <input
        type="text"
        id="searchInput"
        name="search"
        placeholder="Search products...">

    <button class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addModal">
        <i class="fa fa-plus"></i> Add Product
    </button>
</div>

<!-- ADD PRODUCT MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <form action="../../../controllers/add_product.php" method="POST" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category" required>
                            <option value="" disabled selected>Select Category</option>
                            <?php
                            require_once __DIR__ . '/../../../models/categoryModel.php';
                            $categories = getAllCategories();
                            foreach ($categories as $category):
                            ?>
                                <option value="<?= htmlspecialchars($category['name']) ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" required>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save Product
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- EDIT PRODUCT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <form action="../../../controllers/update_product.php" method="POST" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Hidden fields -->
                    <input type="hidden" name="id">
                    <input type="hidden" name="old_image">

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category" required>
                            <option value="" disabled selected>Select Category</option>
                            <?php
                            require_once __DIR__ . '/../../../models/categoryModel.php';
                            $categories = getAllCategories();
                            foreach ($categories as $category):
                            ?>
                                <option value="<?= htmlspecialchars($category['name']) ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Image (optional)</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>

                    <div class="mb-3">
                        <img id="editPreview" src="" class="product-img">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update Product
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- PRODUCT TABLE -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">IMAGE</th>
            <th scope="col">PRODUCT</th>
            <th scope="col">CATEGORY</th>
            <th scope="col">PRICE</th>
            <th scope="col">DESCRIPTION</th>
            <th scope="col">ACTIONS</th>
        </tr>
    </thead>
    <tbody id="productTable">
        <?php
        require_once __DIR__ . '/../../../models/productModel.php';
        $products = getAllProducts();

        if (!empty($products)):
            foreach ($products as $product):
        ?>
                <tr>
                    <td>
                        <img
                            src="<?= htmlspecialchars($product['image']) ?>"
                            alt="Product Image"
                            class="product-img">
                    </td>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td><?= htmlspecialchars($product['description'] ?? 'N/A') ?></td>
                    <td>
                        <a href="#"
                            class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="<?= $product['id'] ?>"
                            data-product_name="<?= htmlspecialchars($product['product_name']) ?>"
                            data-category="<?= htmlspecialchars($product['category']) ?>"
                            data-price="<?= $product['price'] ?>"
                            data-description="<?= htmlspecialchars($product['description'] ?? '') ?>"
                            data-image="<?= htmlspecialchars($product['image']) ?>">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <a href="/products?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this product?');">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="5" class="text-center">No products found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- SEARCH SCRIPT -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#productTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>

<!-- UPDATE PRODUCT JS -->
<script>
    var editModal = document.getElementById('editModal');

    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;

        this.querySelector('input[name="id"]').value = button.getAttribute('data-id');
        this.querySelector('input[name="product_name"]').value = button.getAttribute('data-product_name');
        this.querySelector('select[name="category"]').value = button.getAttribute('data-category');
        this.querySelector('input[name="price"]').value = button.getAttribute('data-price');
        this.querySelector('textarea[name="description"]').value = button.getAttribute('data-description');
        this.querySelector('input[name="old_image"]').value = button.getAttribute('data-image');

        // Image preview
        this.querySelector('#editPreview').src = button.getAttribute('data-image');
    });
</script>


<!-- Bootstrap JS (REQUIRED) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>