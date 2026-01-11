<div class="row">
    <div class="col-md-6">
        <h3>Edit User</h3>
        <form action="<?= BASEURL; ?>/admin/userUpdate" method="post">
            <input type="hidden" name="id" value="<?= $data['user']['id']; ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $data['user']['name']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $data['user']['username']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $data['user']['email']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $data['user']['phone']; ?>">
            </div>
            
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="customer" <?= $data['user']['role'] == 'customer' ? 'selected' : ''; ?>>Customer</option>
                    <option value="admin" <?= $data['user']['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <hr>
            <h5>Reset Password (Opsional)</h5>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Biarkan kosong jika tidak ingin mengubah password">
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="<?= BASEURL; ?>/admin/users" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
