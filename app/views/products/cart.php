<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-shopping-cart fa-2x text-success me-3"></i>
        <h2 class="fw-bold mb-0">Keranjang Belanja</h2>
    </div>
    
    <?php Flasher::flash(); ?>

    <?php if(empty($data['cart_items'])): ?>
        <div class="text-center py-5 bg-white shadow-sm rounded">
            <i class="fas fa-shopping-basket fa-5x text-muted mb-4 opacity-50"></i>
            <h4 class="text-muted mb-3">Wah, keranjang belanjamu kosong!</h4>
            <p class="text-muted mb-4">Yuk, isi dengan produk-produk lokal berkualitas kami.</p>
            <a href="<?= BASEURL; ?>/products" class="btn btn-success px-4 py-2 rounded-pill fw-bold">
                <i class="fas fa-arrow-left me-2"></i>Mulai Belanja
            </a>
        </div>
    <?php else: ?>
        <form action="<?= BASEURL; ?>/products/checkout" method="post" id="cartForm">
        <div class="row g-4">
            <!-- Product List -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <div class="row align-items-center fw-bold text-muted small text-uppercase">
                            <div class="col-md-5 d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                </div>
                                <div>Produk</div>
                            </div>
                            <div class="col-md-2 text-center">Harga Satuan</div>
                            <div class="col-md-2 text-center">Kuantitas</div>
                            <div class="col-md-2 text-center">Total Harga</div>
                            <div class="col-md-1 text-center">Aksi</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php foreach($data['cart_items'] as $item): ?>
                        <div class="p-3 border-bottom hover-bg-light transition-all">
                            <div class="row align-items-center">
                                <!-- Product Info -->
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input item-check" type="checkbox" name="selected_items[]" value="<?= $item['id']; ?>" data-subtotal="<?= $item['subtotal']; ?>" id="checkbox-<?= $item['id']; ?>">
                                        </div>
                                        <div class="flex-shrink-0">
                                            <?php if($item['image']): ?>
                                                <img src="<?= BASEURL; ?>/assets/img/<?= $item['image']; ?>" class="img-fluid rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded border text-muted small" style="width: 80px; height: 80px;">
                                                    <i class="fas fa-image fa-2x opacity-50"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-1 fw-bold text-dark text-truncate" style="max-width: 200px;"><?= $item['name']; ?></h6>
                                            <span class="badge bg-light text-secondary border"><?= $item['category_name']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Unit Price -->
                                <div class="col-md-2 text-center">
                                    <span class="text-muted small">Rp <?= number_format($item['price']); ?></span>
                                </div>
                                
                                <!-- Quantity -->
                                <div class="col-md-2 text-center">
                                    <div class="d-inline-flex align-items-center border rounded">
                                        <button type="button" class="btn btn-sm btn-light border-0 px-2 py-1 qty-btn" onclick="updateQty(<?= $item['id']; ?>, -1)">-</button>
                                        <input type="text" class="form-control form-control-sm border-0 text-center p-0 bg-transparent" value="<?= $item['qty']; ?>" style="width: 40px;" readonly id="qty-input-<?= $item['id']; ?>">
                                        <button type="button" class="btn btn-sm btn-light border-0 px-2 py-1 qty-btn" onclick="updateQty(<?= $item['id']; ?>, 1)">+</button>
                                    </div>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="col-md-2 text-center">
                                    <span class="fw-bold text-success" id="subtotal-<?= $item['id']; ?>">Rp <?= number_format($item['subtotal']); ?></span>
                                </div>
                                
                                <!-- Action -->
                                <div class="col-md-1 text-center">
                                    <a href="<?= BASEURL; ?>/products/deleteFromCart/<?= $item['id']; ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus item ini?');" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <a href="<?= BASEURL; ?>/products" class="text-decoration-none text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Lanjut Belanja
                    </a>
                    <div>
                        <button type="submit" formaction="<?= BASEURL; ?>/products/deleteSelectedCart" class="btn btn-outline-danger btn-sm me-2" onclick="return confirm('Hapus item yang dipilih?');">
                            <i class="fas fa-trash me-1"></i> Hapus Dipilih
                        </button>
                        <a href="<?= BASEURL; ?>/products/clearCart" class="text-danger text-decoration-none small ms-3" onclick="return confirm('Kosongkan semua keranjang?');">
                            Kosongkan Semua
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 6rem; z-index: 10;">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Item Terpilih</span>
                            <span class="fw-bold" id="selectedCount">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="text-success">Gratis Ongkir</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold h5 mb-0">Total Tagihan</span>
                            <span class="fw-bold h5 mb-0 text-success" id="grandTotal">Rp 0</span>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold rounded-pill">
                            Checkout Sekarang <i class="fas fa-chevron-right ms-2"></i>
                        </button>
                        <div class="text-center mt-3 small text-muted">
                            <i class="fas fa-shield-alt me-1"></i> Jaminan Aman & Terpercaya
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>

        <!-- Hidden Form for Qty Update -->
        <form id="qtyForm" action="<?= BASEURL; ?>/products/updateCartQty" method="post" style="display:none;">
            <input type="hidden" name="id" id="qtyId">
            <input type="hidden" name="qty" id="qtyVal">
        </form>

        <script>
            // Check All Logic
            document.getElementById('checkAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.item-check');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateSummary();
            });

            // Individual Check Logic
            document.querySelectorAll('.item-check').forEach(cb => {
                cb.addEventListener('change', function() {
                    const allChecked = document.querySelectorAll('.item-check:checked').length === document.querySelectorAll('.item-check').length;
                    document.getElementById('checkAll').checked = allChecked;
                    updateSummary();
                });
            });

            // Update Summary Logic
            function updateSummary() {
                let total = 0;
                let count = 0;
                document.querySelectorAll('.item-check:checked').forEach(cb => {
                    total += parseFloat(cb.getAttribute('data-subtotal'));
                    count++;
                });
                
                document.getElementById('selectedCount').innerText = count;
                document.getElementById('grandTotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            }

            // Qty Update Logic
            function updateQty(id, change) {
                const input = document.getElementById('qty-input-' + id);
                let newQty = parseInt(input.value) + change;
                if(newQty < 1) return; // Minimum 1

                // Optimistic UI update
                input.value = newQty;
                
                // Send AJAX
                const formData = new FormData();
                formData.append('id', id);
                formData.append('qty', newQty);

                fetch('<?= BASEURL; ?>/products/updateCartQty', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        // Update subtotal text
                        const subtotalElem = document.getElementById('subtotal-' + id);
                        if(subtotalElem) {
                            subtotalElem.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.subtotal);
                        }
                        
                        // Update checkbox data-subtotal
                        const checkbox = document.getElementById('checkbox-' + id);
                        if(checkbox) {
                            checkbox.setAttribute('data-subtotal', data.subtotal);
                            // Recalculate summary if checked
                            if(checkbox.checked) {
                                updateSummary();
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }
            
            // Initialize
            updateSummary();
        </script>
    <?php endif; ?>
</div>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
    .transition-all {
        transition: all 0.2s;
    }
</style>