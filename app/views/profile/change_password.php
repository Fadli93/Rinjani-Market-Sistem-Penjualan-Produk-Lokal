<div class="container mt-4 mb-5">
    <div class="row">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Ubah Password</h5>
                    <small class="text-muted">Untuk keamanan akun Anda, mohon jangan sebarkan password Anda ke orang lain</small>
                </div>
                <div class="card-body">
                    <?php Flasher::flash(); ?>
                    
                    <form action="<?= BASEURL; ?>/profile/updatePasswordHandler" method="post">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="mb-3 row align-items-center">
                                    <label for="current_password" class="col-sm-4 col-form-label text-end text-muted">Password Saat Ini</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        <div class="text-end mt-1">
                                            <a href="<?= BASEURL; ?>/auth/forgotPassword" class="text-decoration-none small text-muted">Lupa Password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label for="new_password" class="col-sm-4 col-form-label text-end text-muted">Password Baru</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label for="confirm_password" class="col-sm-4 col-form-label text-end text-muted">Konfirmasi Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-8 offset-sm-4">
                                        <button type="submit" class="btn btn-success px-4">Ubah Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
