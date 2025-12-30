<?php
$cartItems = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- back to home -->
<div class="m-4">
    <a href="/"
        class="btn  w-100 d-flex align-items-center justify-content-start gap-2 fw-semibold"
        style="color:#662D91;">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Shop
    </a>
</div>

<div class="container">

    <div class="cart-modal-content">
        <?php if (!empty($cartItems)): ?>
            <div class="cart-content-wrapper">
                <!-- CART TABLE -->
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>IMAGE</th>
                            <th>PRODUCT</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>SUBTOTAL</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($cartItems as $id => $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($item['image']) ?>" class="cart-img">
                                </td>

                                <td><?= htmlspecialchars($item['name']) ?></td>

                                <td>$<?= number_format($item['price'], 2) ?></td>

                                <!-- Quantity -->
                                <td>
                                    <div class="qty-control">
                                        <a href="../../../controllers/cart_action.php?action=minus&id=<?= $id ?>">−</a>
                                        <span><?= $item['quantity'] ?></span>
                                        <a href="../../../controllers/cart_action.php?action=plus&id=<?= $id ?>">+</a>
                                    </div>
                                </td>

                                <!-- Subtotal -->
                                <td>$<?= number_format($subtotal, 2) ?></td>

                                <!-- Remove -->
                                <td>
                                    <a href="../../../controllers/cart_action.php?action=remove&id=<?= $id ?>"
                                        class="remove-btn">×
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

                <!-- TOTALS -->
                <div class="cart-totals">
                    <h3>Cart Totals</h3>

                    <table class="totals-table">
                        <tr>
                            <td>Subtotal</td>
                            <td>$<?= number_format($total, 2) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>$<?= number_format($total, 2) ?></strong></td>
                        </tr>
                    </table>

                    <div class="checkout-actions text-end">
                        <a href="/checkout" class="btn btn-primary checkout-btn">
                            Proceed to Checkout
                        </a>
                    </div>


                </div>

            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

    </div>
</div>


<style>
    .container {
        margin-top: 50px;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th {
        font-size: 13px;
        color: #6a1b9a;
        letter-spacing: 1px;
        border-bottom: 1px solid #ddd;
    }

    .cart-table td {
        padding: 20px 10px;
        border-bottom: 1px solid #ddd;
    }

    .cart-img {
        width: 45px;
    }

    .qty-control {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .qty-control a {
        width: 28px;
        height: 28px;
        background: #eee;
        text-align: center;
        line-height: 28px;
        border-radius: 4px;
        color: #000;
        text-decoration: none;
        font-weight: bold;
    }

    .qty-control span {
        width: 30px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .cart-totals {
        margin-top: 50px;
        width: 380px;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-left: auto;
    }

    .checkout-btn {
        display: block;
        margin-top: 20px;
        background: #6a1b9a;
        color: #fff;
        padding: 12px;
        border-radius: 8px;
        width: 100%;
        border: none;
        font-weight: bold;
    }
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>