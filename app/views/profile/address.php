<div class="container mt-4 mb-5">
    <div class="row">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Alamat Saya</h5>
                        <small class="text-muted">Kelola alamat pengiriman Anda</small>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="fas fa-plus me-1"></i> Tambah Alamat Baru
                    </button>
                </div>
                <div class="card-body">
                    <?php Flasher::flash(); ?>
                    
                    <?php if(empty($data['addresses'])): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada alamat tersimpan.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($data['addresses'] as $addr): ?>
                            <div class="card mb-3 border-<?= $addr['is_primary'] ? 'primary' : 'light'; ?> shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-bold mb-1">
                                                <?= $addr['recipient_name']; ?> 
                                                <span class="text-muted fw-normal mx-1">|</span> 
                                                <span class="text-muted fw-normal"><?= $addr['phone']; ?></span>
                                            </h6>
                                            <p class="text-muted mb-2 small"><?= $addr['address']; ?></p>
                                            
                                            <?php if($addr['is_primary']): ?>
                                                <span class="badge bg-outline-primary text-primary border border-primary">Utama</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex flex-column gap-2 text-end">
                                            <div>
                                                <button class="btn btn-link text-decoration-none p-0 me-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editAddressModal<?= $addr['id']; ?>">Ubah</button>
                                                <?php if(!$addr['is_primary']): ?>
                                                    <a href="<?= BASEURL; ?>/profile/deleteAddress/<?= $addr['id']; ?>" class="btn btn-link text-danger text-decoration-none p-0" onclick="return confirm('Yakin ingin menghapus alamat ini?')">Hapus</a>
                                                <?php endif; ?>
                                            </div>
                                            <?php if(!$addr['is_primary']): ?>
                                                <a href="<?= BASEURL; ?>/profile/setPrimaryAddress/<?= $addr['id']; ?>" class="btn btn-outline-secondary btn-sm">Atur sebagai Utama</a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" disabled>Alamat Utama</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editAddressModal<?= $addr['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ubah Alamat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="<?= BASEURL; ?>/profile/updateAddress" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $addr['id']; ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Penerima</label>
                                                    <input type="text" class="form-control" name="recipient_name" value="<?= $addr['recipient_name']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor Telepon</label>
                                                    <input type="text" class="form-control" name="phone" value="<?= $addr['phone']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat Lengkap</label>
                                                    <textarea class="form-control" name="address" rows="3" required><?= $addr['address']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= BASEURL; ?>/profile/addAddress" method="post">
                <div class="modal-body">
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Nama dan No. Telepon akan diambil dari profil Anda.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Nama Jalan, Gedung, No. Rumah, Kecamatan, Kota, Provinsi, Kode Pos" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
