<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php Flasher::flash(); ?>
            <div class="card auth-card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 fw-bold text-success">Lupa Password</h1>
                        <p class="text-muted">Masukkan email Anda untuk mereset password</p>
                    </div>
                    <form action="<?= BASEURL; ?>/auth/processForgotPassword" method="POST">
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="contoh@email.com">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Link Reset</button>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <p class="mb-0 text-muted">Kembali ke <a href="<?= BASEURL; ?>/auth/login" class="text-decoration-none fw-bold text-success">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>