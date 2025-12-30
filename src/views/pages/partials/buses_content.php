<?php
require_once __DIR__ . '/../../../models/buseModel.php';
$deleteBus = deleteBus($_GET['id'] ?? null);
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

    .form-additional-search input[type="text"] {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .form-additional-search button {
        padding: 10px 18px;
    }

    .product-img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
    }
</style>

<div class="form-additional-search">
    <input type="text" id="searchInput" placeholder="Search buses...">

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fa fa-plus"></i> Add Bus
    </button>
</div>

<!-- ADD BUS MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <form action="../../../controllers/add_bus.php" method="POST" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Bus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Bus ID</label>
                        <input type="text" class="form-control" name="busid" id="busid" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bus Name</label>
                        <input type="text" class="form-control" name="busname" id="busname" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bus Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addBusButton">Save Bus</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- EDIT BUS MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <form action="../../../controllers/update_bus.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" id="edit-id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Bus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Bus ID</label>
                        <input type="text" class="form-control" name="busid" id="edit-busid" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bus Name</label>
                        <input type="text" class="form-control" name="busname" id="edit-busname" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password (leave empty to keep old)</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit-description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bus Image (optional)</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
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
                        Update Bus
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- BUS TABLE -->
<table class="table ">
    <thead class="table-light">
        <tr>
            <th>IMAGE</th>
            <th>Bus ID</th>
            <th>Bus Name</th>
            <th>Description</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody id="productTable">
        <?php
        require_once __DIR__ . '/../../../models/buseModel.php';
        $buses = getAllBuses();

        if (!empty($buses)):
            foreach ($buses as $bus):
                if ($bus['role'] === 'admin') {
                    continue; // Skip the admin bus
                }
        ?>
                <tr>
                    <td>
                        <img src="data:image/jpeg;base64,<?= $bus['image'] ?>" class="product-img" alt="Bus Image">
                    </td>
                    <td><?= htmlspecialchars($bus['busid']) ?></td>
                    <td><?= htmlspecialchars($bus['busname']) ?></td>
                    <!-- <td><?= htmlspecialchars($bus['password']) ?></td> -->
                    <td><?= htmlspecialchars($bus['description'] ?? 'N/A') ?></td>
                    <td>
                        <a href="#"
                            class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="<?= $bus['id'] ?>"
                            data-busid="<?= htmlspecialchars($bus['busid']) ?>"
                            data-busname="<?= htmlspecialchars($bus['busname']) ?>"
                            data-description="<?= htmlspecialchars($bus['description'] ?? 'N/A') ?>"
                            data-image="<?= $bus['image'] ?>">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <a href="/buses?id=<?= $bus['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this bus?');">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="5" class="text-center">No buses found</td>
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

<!-- EDIT MODAL SCRIPT -->
<script>
    document.getElementById('editModal').addEventListener('show.bs.modal', function(event) {

        const button = event.relatedTarget;

        document.getElementById('edit-id').value = button.getAttribute('data-id');
        document.getElementById('edit-busid').value = button.getAttribute('data-busid');
        document.getElementById('edit-busname').value = button.getAttribute('data-busname');
        document.getElementById('edit-description').value = button.getAttribute('data-description');
        document.getElementById('editPreview').src = "data:image/jpeg;base64," + button.getAttribute('data-image');

        const editPreview = document.getElementById('editPreview');

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>