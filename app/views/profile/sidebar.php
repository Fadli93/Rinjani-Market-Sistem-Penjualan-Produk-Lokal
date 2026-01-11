<!-- Sidebar -->
<div class="col-md-3 mb-4">
    <div class="d-flex align-items-center mb-4 ps-2">
        <?php 
            $profileImg = 'https://ui-avatars.com/api/?name=' . urlencode($data['user']['name']) . '&background=random';
            if (!empty($data['user']['image']) && file_exists('assets/img/profiles/' . $data['user']['image'])) {
                $profileImg = BASEURL . '/assets/img/profiles/' . $data['user']['image'];
            }
        ?>
        <img src="<?= $profileImg; ?>" 
             alt="Profile" 
             class="rounded-circle me-3 object-fit-cover" 
             width="50" height="50">
        <div>
            <h6 class="mb-0 fw-bold text-truncate" style="max-width: 150px;"><?= $data['user']['name']; ?></h6>
            <a href="<?= BASEURL; ?>/profile" class="text-decoration-none text-muted small"><i class="fas fa-pen"></i> Ubah Profil</a>
        </div>
    </div>

    <div class="list-group list-group-flush">
        <a href="<?= BASEURL; ?>/profile" class="list-group-item list-group-item-action border-0 bg-transparent <?= ($data['active_tab'] ?? '') == 'profile' ? 'active text-primary fw-bold' : 'text-dark'; ?>">
            <i class="fas fa-user <?= ($data['active_tab'] ?? '') == 'profile' ? 'text-primary' : 'text-muted'; ?> me-2" style="width: 20px;"></i> Akun Saya
        </a>
        <div class="ps-5 mb-2">
            <a href="<?= BASEURL; ?>/profile" class="text-decoration-none d-block mb-2 <?= ($data['active_sub_tab'] ?? '') == 'profile' ? 'text-primary' : 'text-muted'; ?>">Profil</a>
            <a href="<?= BASEURL; ?>/profile/address" class="text-decoration-none d-block mb-2 <?= ($data['active_sub_tab'] ?? '') == 'address' ? 'text-primary' : 'text-muted'; ?>">Alamat <span class="text-danger">*</span></a>
            <a href="<?= BASEURL; ?>/profile/changePassword" class="text-decoration-none d-block <?= ($data['active_sub_tab'] ?? '') == 'password' ? 'text-primary' : 'text-muted'; ?>">Ubah Password</a>
        </div>
        <a href="<?= BASEURL; ?>/products/orders" class="list-group-item list-group-item-action border-0 text-dark">
            <i class="fas fa-clipboard-list text-primary me-2" style="width: 20px;"></i> Pesanan Saya
        </a>
        <a href="<?= BASEURL; ?>/auth/logout" class="list-group-item list-group-item-action border-0 text-danger">
            <i class="fas fa-sign-out-alt text-danger me-2" style="width: 20px;"></i> Logout
        </a>
    </div>
</div>
