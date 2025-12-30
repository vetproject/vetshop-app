<?php
$cartItems = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- back to home -->
<div class="m-4">
    <a href="/view_cart"
        class="btn  w-100 d-flex align-items-center justify-content-start gap-2 fw-semibold"
        style="color:#662D91;">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Cart View
    </a>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">
    <div class=" rounded-4 shadow p-4 p-md-5 gap-5">

        <div class="row g-5 ">
            <!-- CUSTOMER INFO -->
            <form action="../../controllers/place_order.php" method="post" class="col-md-6 bg-white p-4 rounded-4 ">

                <h5 class="fw-semibold mb-4">
                    📋 Customer Info
                </h5>

                <!-- Full Name -->
                <div class="mb-3">
                    <input
                        type="text"
                        name="customer_name"
                        class="form-control"
                        placeholder="Full Name"
                        required>
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <input
                        type="tel"
                        name="customer_phone"
                        class="form-control"
                        placeholder="Phone Number"
                        required>
                </div>

                <!-- Email (Optional) -->
                <div class="mb-4">
                    <label for="email" class="form-label">
                        Optional Email Address (to receive ticket)
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="example@email.com">
                </div>

                <!-- total -->
                <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">

                <!-- Submit Button -->
                <button type="submit" class="btn btn-purple w-100 py-3 fw-semibold">
                    Place Order 🛒
                </button>

            </form>


            <!-- ORDER SUMMARY -->
            <div class="col-md-6">
                <h5 class="fw-semibold mb-4">
                    🛒 Order Summary
                </h5>

                <?php foreach ($cartItems as $item): ?>
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="Product Image" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                            <div class="text-muted">
                                <?= htmlspecialchars($item['quantity']) ?> x $<?= number_format($item['price'], 2) ?>
                            </div>
                        </div>
                        <div class="fw-semibold">
                            $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="text-end fw-bold fs-5 mt-4">
                    Total: $<?= htmlspecialchars($total) ?>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- css  -->
<style>
    body {
        background: #f2f3f5;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* INPUTS */
    .form-control {
        height: 52px;
        border-radius: 10px;
        font-size: 15px;
    }

    /* PURPLE BUTTON */
    .btn-purple {
        background-color: #6f2c91;
        color: white;
        border-radius: 10px;
    }

    .btn-purple:hover {
        background-color: #5d2379;
        color: white;
    }

    /* ICON BOX */
    .bg-light {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
</style>