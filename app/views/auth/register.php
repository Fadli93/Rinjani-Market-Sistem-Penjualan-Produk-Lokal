<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php Flasher::flash(); ?>
            <div class="card auth-card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="<?= BASEURL; ?>/assets/img/logo-rinjani-market.png" alt="<?= SITENAME; ?>" class="mb-3" style="max-height: 80px;">
                        <p class="text-muted">Buat akun baru untuk mulai berbelanja</p>
                    </div>
                    <form action="<?= BASEURL; ?>/auth/prosesRegister" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <p class="mb-0 text-muted">Sudah punya akun? <a href="<?= BASEURL; ?>/auth/login" class="text-decoration-none fw-bold text-success">Login disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
