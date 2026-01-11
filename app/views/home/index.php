<!-- Hero Section -->
<section class="hero-section position-relative p-0 mb-3 mb-md-5">
    <div class="w-100 overflow-hidden position-relative" style="border-radius: 0 0 50px 50px;">
        <img src="<?= BASEURL; ?>/assets/img/home produk lokal lombok.png" alt="Banner Produk Lokal" class="w-100 d-block hero-img">
        <div class="position-absolute end-0 text-end hero-btn-container pe-4 pb-4">
            <a href="<?= BASEURL; ?>/products" class="btn btn-success btn-hero fw-bold rounded-pill shadow-lg animate-bounce">Belanja Sekarang</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-3 py-md-5">
    <div class="container">
        <div class="row g-2 g-md-4 text-center">
            <div class="col-4 col-md-4">
                <div class="p-2 p-md-4 h-100">
                    <div class="mb-2 mb-md-3 text-success"><i class="fas fa-shipping-fast fa-2x fa-md-3x"></i></div>
                    <h6 class="fw-bold small-on-mobile mb-1">Pengiriman Cepat</h6>
                    <p class="text-muted small d-none d-md-block">Kami memastikan pesanan Anda sampai dengan aman dan tepat waktu.</p>
                    <p class="text-muted x-small d-block d-md-none lh-sm">Aman & Cepat</p>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="p-2 p-md-4 h-100">
                    <div class="mb-2 mb-md-3 text-success"><i class="fas fa-check-circle fa-2x fa-md-3x"></i></div>
                    <h6 class="fw-bold small-on-mobile mb-1">Kualitas Terjamin</h6>
                    <p class="text-muted small d-none d-md-block">Semua produk telah melalui proses kurasi ketat untuk menjamin kualitas.</p>
                    <p class="text-muted x-small d-block d-md-none lh-sm">Kurasi Ketat</p>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="p-2 p-md-4 h-100">
                    <div class="mb-2 mb-md-3 text-success"><i class="fas fa-hand-holding-heart fa-2x fa-md-3x"></i></div>
                    <h6 class="fw-bold small-on-mobile mb-1">Dukung Lokal</h6>
                    <p class="text-muted small d-none d-md-block">Setiap pembelian Anda membantu perekonomian pengrajin lokal.</p>
                    <p class="text-muted x-small d-block d-md-none lh-sm">Bantu Pengrajin</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Produk Terbaru</h2>
            <a href="<?= BASEURL; ?>/products" class="text-success text-decoration-none fw-bold">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="row g-4">
            <?php 
            $count = 0;
            foreach($data['featured_products'] as $prod): 
                if($count >= 4) break;
                $count++;
            ?>
            <div class="col-md-3">
                <div class="card h-100 product-card">
                    <div class="position-relative overflow-hidden">
                        <?php if($prod['image']): ?>
                            <img src="<?= BASEURL; ?>/assets/img/<?= $prod['image']; ?>" class="card-img-top" alt="<?= $prod['name']; ?>" style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary text-white text-center py-5" style="height: 250px;">No Image</div>
                        <?php endif; ?>
                        <div class="position-absolute bottom-0 end-0 p-3">
                            <button class="btn btn-light rounded-circle shadow-sm text-danger"><i class="far fa-heart"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <small class="text-muted"><?= $prod['category_name']; ?></small>
                        <h5 class="card-title fw-bold mt-1"><?= $prod['name']; ?></h5>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-success fw-bold h5 mb-0">Rp <?= number_format($prod['price']); ?></span>
                            <a href="<?= BASEURL; ?>/products/addToCart/<?= $prod['id']; ?>" class="btn btn-outline-success btn-sm rounded-pill"><i class="fas fa-cart-plus me-1"></i> Add</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
