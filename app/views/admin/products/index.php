<div class="row">
    <div class="col-md-12">
        <h3>Daftar Produk</h3>
        <?php Flasher::flash(); ?>
        
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#formModal">
            Tambah Produk
        </button>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($data['products'] as $prod): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <?php if($prod['image']): ?>
                                <img src="<?= BASEURL; ?>/assets/img/<?= $prod['image']; ?>" width="50">
                            <?php else: ?>
                                <span class="badge badge-secondary">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $prod['name']; ?></td>
                        <td><?= $prod['category_name']; ?></td>
                        <td>Rp <?= number_format($prod['price']); ?></td>
                        <td><?= $prod['stock']; ?></td>
                        <td>
                            <a href="<?= BASEURL; ?>/admin/productEdit/<?= $prod['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= BASEURL; ?>/admin/productDelete/<?= $prod['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('yakin?');">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulModal">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL; ?>/admin/productStore" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" id="category_id" name="category_id">
                    <?php foreach($data['categories'] as $cat): ?>
                        <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
      </div>
    </div>
  </div>
</div>
