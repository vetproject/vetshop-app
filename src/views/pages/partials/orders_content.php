<?php
require_once __DIR__ . '/../../../models/orderModel.php';
$orders = getAllOrders();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $deleted = $_GET['deleted'] ?? null;
    if ($deleted === 'true') {
        echo '<div class="alert alert-success">Order deleted successfully.</div>';
    } elseif ($deleted === 'false') {
        echo '<div class="alert alert-danger">Failed to delete order.</div>';
    }
}
?>
<style>
    .floating-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 260px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        animation: slideIn .4s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
<script>
    setTimeout(() => {
        const alert = document.querySelector(".alert");
        if (alert) {
            alert.style.transition = "opacity .5s";
            alert.style.opacity = "0";

            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>

</script>

<head>
    <meta charset="UTF-8">
    <title>Order History</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ===== SUMMARY CARDS ===== */
        .summary-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: transform .2s ease;
        }

        .summary-card i {
            font-size: 28px;
            color: #4f46e5;
        }

        .summary-card.success i {
            color: #2e9c6a;
        }

        .summary-card.danger i {
            color: #d9534f;
        }

        /* ===== ORDER CARD ===== */
        .order-card {
            height: 90%;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* ===== HEADER ===== */
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .order-tabs span {
            margin-right: 15px;
            cursor: pointer;
            color: #777;
            font-weight: 500;
        }

        .order-tabs .active {
            color: #000;
            font-weight: bold;
            border-bottom: 2px solid #ff7a00;
        }

        /* ===== SEARCH ===== */
        .form-additional-search {
            display: flex;
            gap: 12px;
            margin: 20px 0;
        }

        .form-additional-search input {
            flex: 1;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .form-additional-search button {
            padding: 10px 18px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 6px;
        }

        /* ===== TABLE ===== */
        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table thead {
            background: #eaf2f6;
        }

        .order-table th,
        .order-table td {
            padding: 14px;
        }

        .order-table tbody tr {
            transition: background .2s, transform .15s;
        }

        /* ===== STATUS ===== */
        .status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-Completed {
            background: #e6f7ef;
            color: #2e9c6a;
        }

        .status-cancelled {
            background: #fdeaea;
            color: #d9534f;
        }

        .status i {
            margin-right: 6px;
        }

        /* ===== PAGINATION ===== */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .pagination button {
            margin: 0 5px;
            padding: 6px 10px;
            border-radius: 50%;
            border: none;
            background: #eaf2f6;
        }

        .pagination .active {
            background: #000;
            color: #fff;
        }

        .pagination button:hover {
            background: #4f46e5;
            color: #fff;
        }

        /* ===== ROW HOVER ===== */
        .order-unread {
            font-weight: bold;
            background: #fffbe6;
            border-left: 4px solid #f59e0b;
        }

        .order-table tbody tr {
            cursor: pointer;
        }
    </style>
</head>

<!-- ===== SUMMARY ===== -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="summary-card">
            <i class="fa-solid fa-list"></i>
            <div>
                <h6>Total Orders</h6>
                <h4><?= count($orders) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <i class="fa-solid fa-box"></i>
            <div>
                <h6>Pending</h6>
                <h4><?= count(array_filter($orders, fn($o) => $o['status'] == 'Pending')) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card success">
            <i class="fa-solid fa-check"></i>
            <div>
                <h6>Completed</h6>
                <h4><?= count(array_filter($orders, fn($o) => $o['status'] == 'Completed')) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card danger">
            <i class="fa-solid fa-xmark"></i>
            <div>
                <h6>Cancelled</h6>
                <h4><?= count(array_filter($orders, fn($o) => $o['status'] == 'Cancelled')) ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- ===== ORDER HISTORY ===== -->
<div class="order-card">

    <div class="order-header mb-3">
        <h4>Order History</h4>
        <div class="order-tabs">
            <span class="active">All Orders</span>
            <span>Pending</span>
            <span>Completed</span>
            <span>Cancelled</span>
        </div>
    </div>

    <!-- SEARCH -->
    <div class="form-additional-search">
        <input type="text" id="searchInput" placeholder="Search order, customer, status...">
        <button><i class="fa fa-search"></i> Search</button>
    </div>

    <!-- TABLE -->
    <table class="order-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Products</th>
                <th>Total ($)</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($orders as $order):

                // status class
                if ($order['status'] === 'Completed') {
                    $statusClass = 'status-Completed';
                    $icon = 'fa-circle-check';
                } elseif ($order['status'] === 'Cancelled') {
                    $statusClass = 'status-cancelled';
                    $icon = 'fa-circle-xmark';
                } else {
                    $statusClass = 'status-pending';
                    $icon = 'fa-clock';
                }
            ?>
                <tr class="<?= ($order['isRead'] ?? 1) == 0 ? 'order-unread' : '' ?>"
                    data-href="/order_detail?id=<?= $order['order_id'] ?>">

                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= htmlspecialchars($order['customer_phone']) ?></td>
                    <td><?= htmlspecialchars($order['products']) ?></td>
                    <td><?= number_format($order['total'], 2) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td>
                        <span class="status <?= $statusClass ?>">
                            <i class="fa <?= $icon ?>"></i>
                            <?= htmlspecialchars($order['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="javascript:void(0)"
                            class="me-2 edit-status-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#statusModal"
                            data-order-id="<?= $order['order_id'] ?>">
                            <i class="fa fa-pen-to-square"></i>
                        </a>


                        <a href="../../../controllers/deleted_order.php?order_id=<?= $order['order_id'] ?>">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PAGINATION -->
    <div class="pagination mt-3" id="pagination">
        <button>&lt;</button>
        <button class="active">1</button>
        <!-- <button>2</button>
        <button>3</button> -->
        <button>&gt;</button>
    </div>

</div>

<!-- ===  STATUS    === -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="statusForm" method="POST">
                    <input type="hidden" name="order_id" id="modalOrderId">

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Update Status
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- ===== JS ===== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const rows = Array.from(document.querySelectorAll('.order-table tbody tr'));
            const pagination = document.getElementById('pagination');
            const rowsPerPage = 7;

            let currentPage = 1;
            let filteredRows = [...rows];

            function renderTable() {
                rows.forEach(row => row.style.display = 'none');

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                filteredRows.slice(start, end).forEach(row => {
                    row.style.display = '';
                });
            }

            function renderPagination() {
                pagination.innerHTML = '';
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                if (totalPages <= 1) return;

                // Prev
                const prev = document.createElement('button');
                prev.innerHTML = '&lt;';
                prev.disabled = currentPage === 1;
                prev.onclick = () => {
                    currentPage--;
                    update();
                };
                pagination.appendChild(prev);

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    if (i === currentPage) btn.classList.add('active');
                    btn.onclick = () => {
                        currentPage = i;
                        update();
                    };
                    pagination.appendChild(btn);
                }

                // Next
                const next = document.createElement('button');
                next.innerHTML = '&gt;';
                next.disabled = currentPage === totalPages;
                next.onclick = () => {
                    currentPage++;
                    update();
                };
                pagination.appendChild(next);
            }

            function update() {
                renderTable();
                renderPagination();
            }

            /* 🔍 SEARCH */
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                filteredRows = rows.filter(row =>
                    row.innerText.toLowerCase().includes(value)
                );
                currentPage = 1;
                update();
            });

            /* 🧭 TAB FILTER */
            document.querySelectorAll('.order-tabs span').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelector('.order-tabs .active').classList.remove('active');
                    this.classList.add('active');

                    const filter = this.innerText.toLowerCase();
                    filteredRows = rows.filter(row =>
                        filter === 'all orders' ||
                        row.innerText.toLowerCase().includes(filter)
                    );

                    currentPage = 1;
                    update();
                });
            });

            // Initial load
            update();
        });
    </script>
    <!-- ===== MODAL SCRIPT ===== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusModal = document.getElementById("statusModal");
            const statusForm = document.getElementById("statusForm");
            const orderIdInput = document.getElementById("modalOrderId");

            statusModal.addEventListener("show.bs.modal", function(event) {
                const button = event.relatedTarget;
                const orderId = button.getAttribute("data-order-id");

                // Set hidden input
                orderIdInput.value = orderId;

                // Set form action dynamically
                statusForm.action = "../../../controllers/update_order_status.php?order_id=" + orderId;
            });
        });
    </script>

    <!-- for click -->
    <script>
        document.querySelectorAll('tr[data-href]').forEach(row => {
            row.addEventListener('click', function(e) {
                // prevent click when clicking icons
                if (e.target.closest('a')) return;
                window.location = this.dataset.href;
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>