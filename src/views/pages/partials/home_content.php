<?php
require_once __DIR__ . '/../../../models/productModel.php';
$products = getAllProducts();

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
    .container {
        margin-top: 100px;
    }

    .product-img {
        width: 250px;
        height: 300px;
        object-fit: cover;
        margin: 0 auto;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    .card-footer {
        border: none !important;
    }
</style>

<div class="container py-5">
    <div class="row g-4 justify-content-center">

        <?php foreach ($products as $p) : ?>
            <div class="col-md-3 product-card">

                <form action="../../../controllers/add_to_cart.php" method="POST">
                    <div class="card h-100 text-center">

                        <img src="<?= $p['image'] ?>"
                            class="card-img-top product-img"
                            alt="<?= $p['product_name'] ?>">

                        <div class="card-body">
                            <h5 class="card-title"><?= $p['product_name'] ?></h5>
                            <h6 class="text-primary">$<?= $p['price'] ?></h6>
                        </div>

                        <!-- send product info -->
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="product_name" value="<?= $p['product_name'] ?>">
                        <input type="hidden" name="product_price" value="<?= $p['price'] ?>">
                        <input type="hidden" name="product_category" value="<?= $p['category'] ?>">
                        <input type="hidden" name="product_image" value="<?= $p['image'] ?>">

                        <div class="card-footer bg-white" id="addTocart">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<!-- Js -->
<script>
    document.getElementById('product-search').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();

        document.querySelectorAll('.product-card').forEach(card => {
            let text = card.innerText.toLowerCase();
            card.style.display = text.includes(value) ? '' : 'none';
        });
    });
</script>