<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Kategori</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= BASEURL; ?>/admin/categoryUpdate" method="post">
                <input type="hidden" name="id" value="<?= $data['category']['id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $data['category']['name']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= BASEURL; ?>/admin/categories" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
