<div class="container mt-4 mb-5">
    <div class="row">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Profil Saya</h5>
                    <small class="text-muted">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</small>
                </div>
                <div class="card-body">
                    <?php Flasher::flash(); ?>
                    
                    <?php 
                        $profileImg = !empty($data['user']['image']) ? BASEURL . '/assets/img/profiles/' . $data['user']['image'] : 'https://ui-avatars.com/api/?name=' . urlencode($data['user']['name']) . '&background=0D6EFD&color=fff';
                    ?>

                    <form action="<?= BASEURL; ?>/profile/update" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 border-end">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label text-end text-muted">Username</label>
                                    <div class="col-sm-9">
                                        <p class="mb-0 form-control-plaintext"><?= $data['user']['username']; ?></p>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label for="name" class="col-sm-3 col-form-label text-end text-muted">Nama <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" value="<?= $data['user']['name']; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label for="email" class="col-sm-3 col-form-label text-end text-muted">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $data['user']['email']; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label for="phone" class="col-sm-3 col-form-label text-end text-muted">Nomor Telepon <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $data['user']['phone']; ?>" required placeholder="Contoh: 08123456789">
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label text-end text-muted">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderL" value="L" <?= $data['user']['gender'] == 'L' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="genderL">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderP" value="P" <?= $data['user']['gender'] == 'P' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="genderP">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row align-items-center">
                                    <label for="birthdate" class="col-sm-3 col-form-label text-end text-muted">Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= $data['user']['birthdate']; ?>">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-success px-4">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                                <div class="mb-3 position-relative">
                                    <img src="<?= $profileImg; ?>" 
                                         alt="Profile Preview" 
                                         class="rounded-circle img-thumbnail object-fit-cover" 
                                         width="150" height="150"
                                         id="profilePreview">
                                </div>
                                <label for="image" class="btn btn-outline-secondary btn-sm mb-2">Pilih Gambar</label>
                                <input type="file" class="d-none" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted text-center">Ukuran gambar: maks. 5 MB<br>Format gambar: .JPEG, .PNG</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>