<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
require_once __DIR__ . '/../../../models/buseModel.php';
require_once __DIR__ . '/../../../models/productModel.php';
require_once __DIR__ . '/../../../models/categoryModel.php';
require_once __DIR__ . '/../../../models/orderModel.php';

$countBuses = count(getAllBuses());
$countProducts = count(getAllProducts());
$countCategories = count(getAllCategories());
$countOrders = countOrders();

$topProducts = getTopProducts();
// print_r($topProducts);
?>

<div class="dashboard-cards">
    <div class="row g-4">

        <!-- Total Buses -->
        <div class="col-md-3 col-sm-6">
            <a href="buses" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body text-center">
                        <i class="fa fa-bus fa-2x text-primary mb-2"></i>
                        <h6 class="text-muted">Total Buses</h6>
                        <h2 class="fw-bold"><?= ($countBuses ?? 0) - 1 ?></h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Products -->
        <div class="col-md-3 col-sm-6">
            <a href="/products" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body text-center">
                        <i class="fa fa-box fa-2x text-success mb-2"></i>
                        <h6 class="text-muted">Total Products</h6>
                        <h2 class="fw-bold"><?= $countProducts ?? 0 ?></h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Categories -->
        <div class="col-md-3 col-sm-6">
            <a href="/categories" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body text-center">
                        <i class="fa fa-tags fa-2x text-warning mb-2"></i>
                        <h6 class="text-muted">Categories</h6>
                        <h2 class="fw-bold"><?= $countCategories ?? 0 ?></h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Orders -->
        <div class="col-md-3 col-sm-6">
            <a href="/orders" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body text-center">
                        <i class="fa fa-shopping-cart fa-2x text-danger mb-2"></i>
                        <h6 class="text-muted">Orders</h6>
                        <h2 class="fw-bold"><?= $countOrders ?? 0 ?></h2>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<br>

<h3>Top Selling Products</h3>
<table class="table">
    <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Total Sold</th>
        <th>Total Price</th>
        <th>Top</th>
    </tr>

    <?php if (!empty($topProducts)): ?>
        <?php $rank = 1; ?>
        <?php foreach ($topProducts as $product): ?>
            <tr>
                <td>
                    <img
                        src="<?= htmlspecialchars($product['image']) ?>"
                        alt="Product"
                        width="40"
                        height="40"
                        class="rounded"
                        style="object-fit: cover;">
                </td>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td><?= (int)$product['total_sold'] ?> Sold</td>
                <td>$<?= number_format($product['total_price'], 2) ?></td>
                <td>
                    <span class="badge bg-primary"><?= $rank ?></span>
                </td>
            </tr>
            <?php $rank++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center text-muted">No data found</td>
        </tr>
    <?php endif; ?>
</table>
