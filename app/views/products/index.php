<div class="container py-5">
    <style>
        .category-link {
            transition: all 0.3s;
            display: block;
        }
        .category-link:hover {
            color: #198754 !important; /* Bootstrap success color */
            transform: translateX(5px);
        }
        .category-link.active {
            color: #198754 !important;
            font-weight: bold;
            border-right: 3px solid #198754;
        }
        /* Hover effect for product card */
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    <div class="text-center mb-5">
        <h2 class="fw-bold">Katalog Produk</h2>
        <p class="text-muted">Temukan koleksi lengkap produk lokal terbaik kami</p>
    </div>

    <?php Flasher::flash(); ?>

    <div class="row g-4">
        <!-- Sidebar Filter (Optional, visual only for now) -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold mb-3">Kategori</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= BASEURL; ?>/products" class="text-decoration-none category-link <?= ($data['active_category'] === null) ? 'active' : 'text-muted'; ?>">
                            Semua Produk
                        </a>
                    </li>
                    <?php foreach($data['categories'] as $cat): ?>
                        <li class="mb-2">
                            <a href="<?= BASEURL; ?>/products?category=<?= $cat['id']; ?><?= $data['max_price'] ? '&price='.$data['max_price'] : '' ?>" class="text-decoration-none category-link <?= ($data['active_category'] == $cat['id']) ? 'active' : 'text-muted'; ?>">
                                <?= $cat['name']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <hr>
                <h5 class="fw-bold mb-3">Filter Harga</h5>
                <form action="<?= BASEURL; ?>/products" method="get" id="filterForm">
                    <?php if($data['active_category']): ?>
                        <input type="hidden" name="category" value="<?= $data['active_category']; ?>">
                    <?php endif; ?>
                    
                    <label for="customRange1" class="form-label">Maksimal: <span id="priceVal" class="fw-bold text-success">Rp <?= number_format($data['max_price'] ?? $data['max_price_limit']); ?></span></label>
                    <input type="range" class="form-range" id="customRange1" name="price" 
                        min="<?= $data['min_price_limit']; ?>" 
                        max="<?= $data['max_price_limit']; ?>" 
                        value="<?= $data['max_price'] ?? $data['max_price_limit']; ?>"
                        oninput="updatePrice(this.value)"
                        onchange="this.form.submit()">
                </form>
                <script>
                    function updatePrice(val) {
                        document.getElementById('priceVal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                    }
                </script>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-4">
                <?php foreach($data['products'] as $prod): ?>
                <div class="col-md-4">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <div class="position-relative overflow-hidden">
                            <?php if($prod['image']): ?>
                                <img src="<?= BASEURL; ?>/assets/img/<?= $prod['image']; ?>" 
                                     class="card-img-top cursor-pointer" 
                                     alt="<?= $prod['name']; ?>" 
                                     style="height: 250px; object-fit: cover;"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#productDetailModal"
                                     data-name="<?= htmlspecialchars($prod['name']); ?>"
                                     data-desc="<?= htmlspecialchars($prod['description']); ?>"
                                     data-price="<?= number_format($prod['price']); ?>"
                                     data-category="<?= htmlspecialchars($prod['category_name']); ?>"
                                     data-image="<?= BASEURL; ?>/assets/img/<?= $prod['image']; ?>"
                                     data-link="<?= BASEURL; ?>/products/addToCart/<?= $prod['id']; ?>"
                                     title="Klik untuk melihat detail">
                            <?php else: ?>
                                <div class="bg-secondary text-white text-center py-5 cursor-pointer" style="height: 250px;"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#productDetailModal"
                                     data-name="<?= htmlspecialchars($prod['name']); ?>"
                                     data-desc="<?= htmlspecialchars($prod['description']); ?>"
                                     data-price="<?= number_format($prod['price']); ?>"
                                     data-category="<?= htmlspecialchars($prod['category_name']); ?>"
                                     data-image=""
                                     data-link="<?= BASEURL; ?>/products/addToCart/<?= $prod['id']; ?>"
                                     title="Klik untuk melihat detail">
                                    No Image
                                </div>
                            <?php endif; ?>
                            <?php if($prod['stock'] < 5): ?>
                                <span class="position-absolute top-0 start-0 badge bg-warning m-3">Stok Terbatas</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <small class="text-muted"><?= $prod['category_name']; ?></small>
                            <h5 class="card-title fw-bold mt-1"><?= $prod['name']; ?></h5>
                            <p class="card-text text-muted small flex-grow-1"><?= substr($prod['description'], 0, 80); ?>...</p>
                            
                            <hr class="my-3 border-light">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Harga</small>
                                    <span class="text-success fw-bold h5 mb-0">Rp <?= number_format($prod['price']); ?></span>
                                </div>
                                <a href="<?= BASEURL; ?>/products/addToCart/<?= $prod['id']; ?>" class="btn btn-success rounded-pill px-3"><i class="fas fa-cart-plus me-1"></i> Beli</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Produk -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 15px;">
      <div class="row g-0">
        <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-0 position-relative">
             <img id="modalImage" src="" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 300px; max-height: 500px;">
             <div id="modalNoImage" class="d-none text-muted">No Image Available</div>
        </div>
        <div class="col-md-6">
            <div class="modal-header border-0 pb-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <span id="modalCategory" class="badge bg-success mb-2"></span>
                <h3 id="modalName" class="fw-bold mb-3"></h3>
                <h4 class="text-success fw-bold mb-3">Rp <span id="modalPrice"></span></h4>
                <div class="overflow-auto" style="max-height: 200px;">
                    <p id="modalDesc" class="text-muted mb-4" style="line-height: 1.6;"></p>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <a id="modalCartLink" href="#" class="btn btn-success btn-lg rounded-pill shadow-sm">
                        <i class="fas fa-cart-plus me-2"></i> Beli Sekarang
                    </a>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    var productDetailModal = document.getElementById('productDetailModal')
    productDetailModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        
        // Extract info from data-bs-* attributes
        var name = button.getAttribute('data-name')
        var desc = button.getAttribute('data-desc')
        var price = button.getAttribute('data-price')
        var category = button.getAttribute('data-category')
        var image = button.getAttribute('data-image')
        var link = button.getAttribute('data-link')
        
        // Update the modal's content.
        productDetailModal.querySelector('#modalName').textContent = name
        productDetailModal.querySelector('#modalDesc').textContent = desc
        productDetailModal.querySelector('#modalPrice').textContent = price
        productDetailModal.querySelector('#modalCategory').textContent = category
        productDetailModal.querySelector('#modalCartLink').setAttribute('href', link)
        
        var imgElem = productDetailModal.querySelector('#modalImage')
        var noImgElem = productDetailModal.querySelector('#modalNoImage')
        
        if(image) {
            imgElem.src = image
            imgElem.classList.remove('d-none')
            noImgElem.classList.add('d-none')
        } else {
            imgElem.classList.add('d-none')
            noImgElem.classList.remove('d-none')
        }
    })
</script>