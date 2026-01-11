<div class="row">
    <div class="col-md-12">
        <h3>Manajemen User</h3>
        <?php Flasher::flash(); ?>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($data['users'] as $user): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td>
                            <?php if($user['role'] == 'admin'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-primary">Customer</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>
                        <td>
                            <a href="<?= BASEURL; ?>/admin/userEdit/<?= $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <?php if($user['id'] != $_SESSION['user_id']): ?>
                                <a href="<?= BASEURL; ?>/admin/userDelete/<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?');">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
