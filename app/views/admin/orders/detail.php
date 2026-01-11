<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Detail Pesanan #<?= $data['order']['id']; ?></h3>
            <a href="<?= BASEURL; ?>/admin/orders" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Pelanggan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150">Nama</td>
                                <td>: <strong><?= $data['order']['user_name']; ?></strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal Order</td>
                                <td>: <?= $data['order']['created_at']; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <?php 
                                        $badgeClass = 'bg-secondary text-white';
                                        if($data['order']['status'] == 'completed') $badgeClass = 'bg-success text-white';
                                        elseif($data['order']['status'] == 'pending' || $data['order']['status'] == 'pending_payment') $badgeClass = 'bg-warning text-dark';
                                        elseif($data['order']['status'] == 'cancelled') $badgeClass = 'bg-danger text-white';
                                    ?>
                                    : <span class="badge <?= $badgeClass; ?>">
                                        <?= $data['order']['status']; ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Informasi Pengiriman & Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150">Kurir</td>
                                <td>: <?= $data['order']['shipping_courier']; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: <?= $data['order']['shipping_address']; ?></td>
                            </tr>
                            <tr>
                                <td>Metode Bayar</td>
                                <td>: <?= ucfirst($data['order']['payment_method']); ?></td>
                            </tr>
                            <?php if(!empty($data['order']['payment_provider'])): ?>
                            <tr>
                                <td>Provider</td>
                                <td>: <?= $data['order']['payment_provider']; ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Produk</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['order_items'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= BASEURL; ?>/assets/img/<?= $item['product_image']; ?>" alt="<?= $item['product_name']; ?>" width="50" class="me-2 rounded">
                                        <span><?= $item['product_name']; ?></span>
                                    </div>
                                </td>
                                <td>Rp <?= number_format($item['price']); ?></td>
                                <td><?= $item['quantity']; ?></td>
                                <td>Rp <?= number_format($item['subtotal']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Ongkos Kirim</strong></td>
                                <td>Rp <?= number_format($data['order']['shipping_cost']); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total Pembayaran</strong></td>
                                <td><strong>Rp <?= number_format($data['order']['total_amount']); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>