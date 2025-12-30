<div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Shopping Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <?php
        $cart = $_SESSION['cart'] ?? [];
        ?>

        <div id="cartItems">
            <?php if (empty($cart)): ?>
                <p>Your cart is empty</p>
            <?php else: ?>

                <?php
                $total = 0;
                foreach ($cart as $item):
                    $itemTotal = $item['price'] * $item['quantity'];
                    $total += $itemTotal;
                ?>
                    <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                        <img src="<?= $item['image'] ?>" width="60" height="60" class="rounded">

                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-0"><?= $item['name'] ?></h6>
                            <small>$<?= $item['price'] ?> x <?= $item['quantity'] ?></small>
                        </div>

                        <strong>$<?= number_format($itemTotal, 2) ?></strong>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <hr>

        <div class="d-flex justify-content-between fw-bold">
            <span>Total:</span>
            <span id="cartTotal">
                $<?= isset($total) ? number_format($total, 2) : "0.00" ?>
            </span>
        </div>
        <a href="/view_cart" class="btn btn-primary w-100 mt-3">
            Cart View
        </a>
        <a href="/checkout" class="btn btn-primary w-100 mt-3">
            Checkout
        </a>

    </div>
</div>