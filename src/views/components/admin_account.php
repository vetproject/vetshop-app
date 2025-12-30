<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <div class="modal-header">
                <h5 class="modal-title">Login to Your Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="../../controllers/admin_login.php" method="POS​​​​​​​T">

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="username" id="name" class="form-control" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <button type="submit" id="login" class="btn btn-primary w-100">Login</button>

                </form>

            </div>

        </div>
    </div>
</div>