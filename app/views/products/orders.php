<div class="container mt-4 mb-5">
    <h3 class="mb-4">Riwayat Pesanan</h3>
    <?php Flasher::flash(); ?>

    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="#" onclick="filterOrders('all', this); return false;">Semua</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="filterOrders('pending', this); return false;">Belum Bayar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="filterOrders('completed', this); return false;">Selesai</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="filterOrders('cancelled', this); return false;">Dibatalkan</a>
        </li>
    </ul>

    <div id="order-list">
        <?php if(empty($data['orders'])): ?>
            <div class="alert alert-info text-center">Belum ada riwayat pesanan.</div>
        <?php else: ?>
            <?php foreach($data['orders'] as $order): ?>
                <?php 
                    $statusGroup = 'all';
                    if($order['status'] == 'pending' || $order['status'] == 'pending_payment') $statusGroup = 'pending';
                    elseif($order['status'] == 'completed') $statusGroup = 'completed';
                    elseif($order['status'] == 'cancelled') $statusGroup = 'cancelled';
                    
                    // Check expiry for pending payment
                    $isExpired = false;
                    if ($order['status'] == 'pending_payment') {
                         $createdAt = strtotime($order['created_at']);
                         $deadline = $createdAt + 86400; // 24 hours
                         if (time() > $deadline) {
                             $isExpired = true;
                         }
                    }
                ?>
                <div class="card mb-3 shadow-sm order-item" data-status="<?= $statusGroup; ?>">
                    <div class="card-body">
                        <!-- Header: Status -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <span class="fw-bold me-2"><i class="fas fa-store text-success me-1"></i> Toko Produk Lokal</span>
                                <span class="text-muted small border-start ps-2 ms-2">Order #<?= $order['id']; ?></span>
                                <span class="text-muted small ms-2"><?= date('d M Y H:i', strtotime($order['created_at'])); ?></span>
                            </div>
                            <?php 
                                 $badgeClass = 'bg-secondary text-white';
                                 $statusText = $order['status'];
                                 
                                 if($order['status'] == 'completed') { 
                                     $badgeClass = 'bg-success text-white'; 
                                     $statusText = 'Selesai'; 
                                 }
                                 elseif($order['status'] == 'pending' || $order['status'] == 'pending_payment') { 
                                     if ($isExpired && $order['status'] == 'pending_payment') {
                                         $badgeClass = 'bg-danger text-white';
                                         $statusText = 'Kadaluarsa';
                                     } else {
                                         if ($order['payment_method'] == 'cod') {
                                             $badgeClass = 'bg-info text-white';
                                             $statusText = 'Siap Dikirim (COD)';
                                         } else {
                                             $badgeClass = 'bg-warning text-dark'; 
                                             $statusText = 'Menunggu Pembayaran'; 
                                         }
                                     }
                                 }
                                 elseif($order['status'] == 'cancelled') { 
                                     $badgeClass = 'bg-danger text-white'; 
                                     $statusText = 'Dibatalkan'; 
                                 }
                            ?>
                            <span class="badge <?= $badgeClass; ?>"><?= $statusText; ?></span>
                        </div>

                        <!-- Product Info -->
                        <?php if($order['first_item']): ?>
                        <div class="d-flex mb-3 cursor-pointer" onclick="window.location.href='<?= BASEURL; ?>/products/orderDetail/<?= $order['id']; ?>'" style="cursor: pointer;">
                            <div class="flex-shrink-0">
                                <?php if($order['first_item']['product_image']): ?>
                                    <img src="<?= BASEURL; ?>/assets/img/<?= $order['first_item']['product_image']; ?>" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold"><?= $order['first_item']['product_name']; ?></h6>
                                <p class="text-muted small mb-1">x<?= $order['first_item']['quantity']; ?></p>
                                
                                <?php 
                                    $otherItemsCount = count($order['items']) - 1;
                                    if($otherItemsCount > 0): 
                                ?>
                                    <small class="text-muted">dan <?= $otherItemsCount; ?> produk lainnya</small>
                                <?php endif; ?>
                                
                                <div class="mt-2 text-success small">
                                    <i class="fas fa-truck me-1"></i> Estimasi tiba: <strong><?= $order['estimation']; ?></strong>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Footer: Total & Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top bg-light mx-n3 px-3 mb-n3 pb-3 rounded-bottom">
                            <div>
                                <small class="text-muted">Total Pesanan</small>
                                <h5 class="text-danger fw-bold mb-0">Rp <?= number_format($order['total_amount']); ?></h5>
                            </div>
                            <div>
                                <?php if($order['status'] == 'pending_payment' && !$isExpired): ?>
                                    <a href="<?= BASEURL; ?>/products/orderDetail/<?= $order['id']; ?>" class="btn btn-primary btn-sm px-4">Bayar Sekarang</a>
                                <?php elseif($order['status'] == 'completed'): ?>
                                    <a href="<?= BASEURL; ?>/products/index" class="btn btn-primary btn-sm px-4">Beli Lagi</a>
                                    <a href="<?= BASEURL; ?>/products/orderDetail/<?= $order['id']; ?>" class="btn btn-outline-secondary btn-sm px-4">Detail</a>
                                <?php else: ?>
                                    <a href="<?= BASEURL; ?>/products/orderDetail/<?= $order['id']; ?>" class="btn btn-outline-secondary btn-sm px-4">Lihat Detail</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function filterOrders(status, element) {
    // Update active tab
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    element.classList.add('active');

    // Filter items
    const items = document.querySelectorAll('.order-item');
    items.forEach(item => {
        if (status === 'all') {
            item.style.display = 'block';
        } else {
            if (item.getAttribute('data-status') === status) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        }
    });
}
</script>