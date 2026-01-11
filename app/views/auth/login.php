<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php Flasher::flash(); ?>
            <div class="card auth-card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="<?= BASEURL; ?>/assets/img/logo-rinjani-market.png" alt="<?= SITENAME; ?>" class="mb-3" style="max-height: 80px;">
                        <p class="text-muted">Silakan login untuk melanjutkan</p>
                    </div>
                    <form action="<?= BASEURL; ?>/auth/prosesLogin" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="text-end mt-1">
                                <a href="<?= BASEURL; ?>/auth/forgotPassword" class="text-decoration-none small text-muted">Lupa Password?</a>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <p class="mb-0 text-muted">Belum punya akun? <a href="<?= BASEURL; ?>/auth/register" class="text-decoration-none fw-bold text-success">Daftar sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
