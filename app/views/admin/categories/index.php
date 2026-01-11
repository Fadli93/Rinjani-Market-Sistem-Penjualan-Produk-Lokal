<div class="row">
    <div class="col-md-12">
        <h3>Daftar Kategori</h3>
        <?php Flasher::flash(); ?>
        
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#formModal">
            Tambah Kategori
        </button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($data['categories'] as $cat): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $cat['name']; ?></td>
                    <td>
                        <a href="<?= BASEURL; ?>/admin/categoryEdit/<?= $cat['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= BASEURL; ?>/admin/categoryDelete/<?= $cat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('yakin?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulModal">Tambah Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL; ?>/admin/categoryStore" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" required>
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
