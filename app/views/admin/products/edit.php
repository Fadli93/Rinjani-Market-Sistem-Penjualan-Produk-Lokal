<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Produk</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= BASEURL; ?>/admin/productUpdate" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['product']['id']; ?>">
                <input type="hidden" name="oldImage" value="<?= $data['product']['image']; ?>">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $data['product']['name']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <?php foreach($data['categories'] as $cat): ?>
                            <?php $selected = ($cat['id'] == $data['product']['category_id']) ? 'selected' : ''; ?>
                            <option value="<?= $cat['id']; ?>" <?= $selected; ?>>
                                <?= $cat['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= $data['product']['description']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $data['product']['price']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= $data['product']['stock']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <div class="mb-2">
                        <?php if($data['product']['image']): ?>
                            <img src="<?= BASEURL; ?>/assets/img/<?= $data['product']['image']; ?>" width="100" class="img-thumbnail">
                        <?php else: ?>
                            <span class="badge bg-secondary">No Image</span>
                        <?php endif; ?>
                    </div>
                    <input type="file" class="form-control" id="image" name="image">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= BASEURL; ?>/admin/products" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
