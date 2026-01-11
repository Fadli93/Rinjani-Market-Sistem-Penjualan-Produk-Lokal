<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Pesanan #<?= $data['order']['id']; ?></h3>
        <a href="<?= BASEURL; ?>/products/orders" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <!-- Countdown Timer Section -->
    <?php 
        $createdAt = strtotime($data['order']['created_at']);
        $deadline = $createdAt + 86400; // 24 hours
        $remainingSeconds = $deadline - time();
        $isExpired = $remainingSeconds <= 0;
    ?>

    <?php if($data['order']['status'] == 'pending_payment' && !$isExpired): ?>
    <div class="alert alert-warning text-center shadow-sm" role="alert">
        <h5><i class="fas fa-clock"></i> Selesaikan Pembayaran Dalam</h5>
        <h2 id="countdown" class="fw-bold text-danger">--:--:--</h2>
        <p class="mb-0">Batas Waktu: <?= date('d M Y H:i', $deadline); ?></p>
        <small class="text-muted">Pesanan akan otomatis dibatalkan jika melewati batas waktu.</small>
    </div>
    <?php elseif($data['order']['status'] == 'pending_payment' && $isExpired): ?>
    <div class="alert alert-danger text-center shadow-sm" role="alert">
        <h5><i class="fas fa-times-circle"></i> Waktu Pembayaran Habis</h5>
        <p class="mb-0">Pesanan ini telah melewati batas waktu pembayaran.</p>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Payment & Shipping Info -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave"></i> Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                         <tr>
                            <td>Metode</td>
                            <td>: <strong><?= ucfirst($data['order']['payment_method']); ?></strong></td>
                        </tr>
                        <?php if($data['order']['payment_method'] == 'transfer'): ?>
                        <tr>
                            <td>Bank/E-Wallet</td>
                            <td>: <strong><?= $data['order']['payment_provider']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>No. Rekening</td>
                            <td>: 
                                <strong>
                                <?php 
                                    if(strpos(strtolower($data['order']['payment_provider']), 'bca') !== false) echo '1234567890 (Admin Toko)';
                                    elseif(strpos(strtolower($data['order']['payment_provider']), 'bri') !== false) echo '0987654321 (Admin Toko)';
                                    elseif(strpos(strtolower($data['order']['payment_provider']), 'dana') !== false) echo '08123456789 (Admin Toko)';
                                    else echo 'Hubungi Admin';
                                ?>
                                </strong>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>Total Bayar</td>
                            <td>: <strong class="text-success fs-5">Rp <?= number_format($data['order']['total_amount']); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: 
                                <?php 
                                    $badgeClass = 'bg-secondary text-white';
                                    $statusText = $data['order']['status'];
                                    
                                    if($data['order']['status'] == 'completed') {
                                        $badgeClass = 'bg-success text-white';
                                        $statusText = 'Selesai';
                                    } elseif($data['order']['status'] == 'pending' || $data['order']['status'] == 'pending_payment') {
                                        if ($isExpired && $data['order']['status'] == 'pending_payment') {
                                            $badgeClass = 'bg-danger text-white';
                                            $statusText = 'Kadaluarsa';
                                        } else {
                                            if ($data['order']['payment_method'] == 'cod') {
                                                $badgeClass = 'bg-info text-white';
                                                $statusText = 'Siap Dikirim (COD)';
                                            } else {
                                                $badgeClass = 'bg-warning text-dark';
                                                $statusText = 'Menunggu Pembayaran';
                                            }
                                        }
                                    } elseif($data['order']['status'] == 'cancelled') {
                                        $badgeClass = 'bg-danger text-white';
                                        $statusText = 'Dibatalkan';
                                    }
                                ?>
                                <span class="badge <?= $badgeClass; ?>"><?= $statusText; ?></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="col-md-6">
             <div class="card mb-4 shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-truck"></i> Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Alamat Pengiriman:</strong></p>
                    <p class="text-muted border p-2 rounded bg-light"><?= $data['order']['shipping_address']; ?></p>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span><strong>Kurir:</strong></span>
                        <span><?= $data['order']['shipping_courier']; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span><strong>Ongkos Kirim:</strong></span>
                        <span>Rp <?= number_format($data['order']['shipping_cost']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product List -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-box"></i> Produk yang Dibeli</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end pe-4">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['order_items'] as $item): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="<?= BASEURL; ?>/assets/img/<?= $item['product_image']; ?>" alt="<?= $item['product_name']; ?>" width="60" height="60" class="me-3 rounded object-fit-cover">
                                    <div>
                                        <h6 class="mb-0"><?= $item['product_name']; ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?= $item['quantity']; ?></td>
                            <td class="text-end">Rp <?= number_format($item['price']); ?></td>
                            <td class="text-end pe-4 fw-bold">Rp <?= number_format($item['subtotal']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Pembayaran</td>
                            <td class="text-end pe-4 fw-bold text-success fs-5">Rp <?= number_format($data['order']['total_amount']); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Countdown Timer
    <?php if($data['order']['status'] == 'pending_payment' && !$isExpired): ?>
    var deadline = new Date("<?= date('M d, Y H:i:s', $deadline); ?>").getTime();
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = deadline - now;
        
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("countdown").innerHTML = hours + "j " + minutes + "m " + seconds + "d ";
        
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
            location.reload();
        }
    }, 1000);
    <?php endif; ?>

    function copyToClipboard(elementId) {
        // Get the text content
        var copyText = document.getElementById(elementId).innerText.trim();
        
        // Create a temporary textarea element
        var tempInput = document.createElement("textarea");
        tempInput.value = copyText;
        document.body.appendChild(tempInput);
        
        // Select and copy
        tempInput.select();
        document.execCommand("copy");
        
        // Remove the temporary element
        document.body.removeChild(tempInput);
        
        // Alert/Feedback
        alert("Nomor rekening berhasil disalin: " + copyText);
    }
</script>