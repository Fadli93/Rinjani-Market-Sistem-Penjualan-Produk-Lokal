<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php Flasher::flash(); ?>
            <div class="card auth-card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 fw-bold text-success">Reset Password</h1>
                        <p class="text-muted">Buat password baru untuk akun Anda</p>
                    </div>
                    <form action="<?= BASEURL; ?>/auth/processResetPassword" method="POST">
                        <input type="hidden" name="token" value="<?= $data['token']; ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="6" autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>