<div class="row">
    <div class="col-md-12">
        <h3>Daftar Pesanan Masuk</h3>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['orders'] as $order): ?>
                    <tr>
                        <td>#<?= $order['id']; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if($order['user_image']): ?>
                                    <img src="<?= BASEURL; ?>/assets/img/profiles/<?= $order['user_image']; ?>" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                                <span><?= $order['user_name']; ?></span>
                            </div>
                        </td>
                        <td><?= $order['created_at']; ?></td>
                        <td>Rp <?= number_format($order['total_amount']); ?></td>
                        <td>
                            <?php 
                                $badgeClass = 'bg-secondary text-white';
                                if($order['status'] == 'completed') $badgeClass = 'bg-success text-white';
                                elseif($order['status'] == 'pending' || $order['status'] == 'pending_payment') $badgeClass = 'bg-warning text-dark';
                                elseif($order['status'] == 'cancelled') $badgeClass = 'bg-danger text-white';
                            ?>
                            <span class="badge <?= $badgeClass; ?> mb-2">
                                <?= $order['status']; ?>
                            </span>

                            <?php if($order['status'] == 'pending_payment'): ?>
                                <form action="<?= BASEURL; ?>/admin/orderUpdateStatus" method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-sm btn-outline-success d-block w-100 mt-1" onclick="return confirm('Konfirmasi pembayaran selesai untuk pesanan #<?= $order['id']; ?>?')">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                </form>
                            <?php elseif($order['status'] == 'pending'): ?>
                                <form action="<?= BASEURL; ?>/admin/orderUpdateStatus" method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-sm btn-outline-success d-block w-100 mt-1" onclick="return confirm('Tandai pesanan #<?= $order['id']; ?> sebagai selesai?')">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASEURL; ?>/admin/orderDetail/<?= $order['id']; ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= BASEURL; ?>/admin/orderDelete/<?= $order['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
