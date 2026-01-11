<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= BASEURL; ?>/products/cart" class="text-decoration-none text-success me-3">
            <i class="fas fa-arrow-left fa-lg"></i>
        </a>
        <h3 class="fw-bold mb-0 text-success"><i class="fas fa-money-check-alt me-2"></i> Checkout</h3>
    </div>

    <form action="<?= BASEURL; ?>/products/processOrder" method="post" id="checkoutForm">
        <!-- Hidden input to pass items data -->
        <input type="hidden" name="items" value='<?= json_encode($data['items_to_checkout']); ?>'>
        
        <div class="row g-4">
            <!-- Left Column: Address, Products, Shipping -->
            <div class="col-lg-8">
                
                <!-- Alamat Pengiriman -->
                <div class="card shadow-sm border-top-success mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-success"><i class="fas fa-map-marker-alt me-2"></i> Alamat Pengiriman</h5>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changeAddressModal">Ubah</button>
                        </div>
                        <div class="p-3 bg-light rounded" id="selectedAddressDisplay">
                            <h6 class="fw-bold mb-1" id="displayRecipient"><?= $data['primary_address']['recipient_name']; ?> (<?= $data['primary_address']['phone']; ?>)</h6>
                            <p class="mb-0 text-muted small" id="displayAddress"><?= $data['primary_address']['address']; ?></p>
                            <?php if($data['primary_address']['is_primary']): ?>
                                <span class="badge bg-success mt-2" id="displayBadge">Utama</span>
                            <?php else: ?>
                                <span class="badge bg-secondary mt-2" id="displayBadge" style="display:none;">Terpilih</span>
                            <?php endif; ?>
                            
                            <!-- Hidden inputs for form submission -->
                            <input type="hidden" name="address" id="formAddress" value="<?= $data['primary_address']['address']; ?>">
                            <input type="hidden" name="recipient_name" id="formRecipient" value="<?= $data['primary_address']['recipient_name']; ?>">
                            <input type="hidden" name="phone" id="formPhone" value="<?= $data['primary_address']['phone']; ?>">
                        </div>
                    </div>
                </div>

                <!-- Produk Dipesan -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0"><i class="fas fa-box me-2"></i> Produk Dipesan</h6>
                    </div>
                    <div class="card-body p-0">
                        <?php foreach($data['items_to_checkout'] as $item): ?>
                        <div class="d-flex p-3 border-bottom">
                            <div class="flex-shrink-0">
                                <?php if($item['product']['image']): ?>
                                    <img src="<?= BASEURL; ?>/assets/img/<?= $item['product']['image']; ?>" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="fw-bold mb-1"><?= $item['product']['name']; ?></h6>
                                <p class="text-muted small mb-1">Kategori: <?= $item['product']['category_name']; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">x<?= $item['qty']; ?></span>
                                    <span class="fw-bold text-dark">Rp <?= number_format($item['subtotal']); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Opsi Pengiriman -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-success mb-3"><i class="fas fa-shipping-fast me-2"></i> Opsi Pengiriman</h5>
                        
                        <div class="list-group">
                            <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center cursor-pointer">
                                <div>
                                    <input class="form-check-input me-2" type="radio" name="shipping_courier_select" value="reguler" data-cost="15000" data-name="JNE Reguler" checked>
                                    <span class="fw-bold">Reguler (JNE)</span>
                                    <div class="small text-muted ms-4">Estimasi tiba 3-5 hari</div>
                                </div>
                                <span class="fw-bold text-dark">Rp 15.000</span>
                            </label>
                            
                            <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center cursor-pointer">
                                <div>
                                    <input class="form-check-input me-2" type="radio" name="shipping_courier_select" value="hemat" data-cost="10000" data-name="SiCepat Halu">
                                    <span class="fw-bold">Hemat (SiCepat)</span>
                                    <div class="small text-muted ms-4">Estimasi tiba 5-7 hari</div>
                                </div>
                                <span class="fw-bold text-dark">Rp 10.000</span>
                            </label>

                            <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center cursor-pointer">
                                <div>
                                    <input class="form-check-input me-2" type="radio" name="shipping_courier_select" value="instant" data-cost="25000" data-name="GoSend Instant">
                                    <span class="fw-bold">Instant (GoSend)</span>
                                    <div class="small text-muted ms-4">Estimasi tiba hari ini</div>
                                </div>
                                <span class="fw-bold text-dark">Rp 25.000</span>
                            </label>
                        </div>
                        <input type="hidden" name="shipping_courier" id="shipping_courier" value="JNE Reguler">
                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="15000">
                    </div>
                </div>

            </div>

            <!-- Right Column: Payment & Summary -->
            <div class="col-lg-4">
                
                <!-- Metode Pembayaran -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-success mb-3"><i class="fas fa-wallet me-2"></i> Metode Pembayaran</h5>
                        
                        <div class="d-grid gap-2">
                            <input type="radio" class="btn-check" name="payment_method" id="cod" value="COD" checked>
                            <label class="btn btn-outline-success text-start d-flex justify-content-between align-items-center" for="cod">
                                <span><i class="fas fa-hand-holding-usd me-2"></i> Bayar di Tempat (COD)</span>
                                <i class="fas fa-check-circle check-icon"></i>
                            </label>

                            <div class="form-check p-3 border rounded mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_transfer" value="transfer" onchange="togglePaymentDetails()">
                                <label class="form-check-label w-100" for="payment_transfer">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university text-primary me-3 fs-4"></i>
                                        <div>
                                            <div class="fw-bold">Transfer Bank / E-Wallet</div>
                                            <small class="text-muted">BCA, BRI, Mandiri, DANA</small>
                                        </div>
                                    </div>
                                </label>
                                <!-- Hidden Payment Details -->
                                <div id="transfer_details" class="mt-3 ps-4 border-top pt-3" style="display: none;">
                                    <p class="small text-danger mb-2">*Harap transfer dalam waktu 1x24 jam. Jika melewati batas waktu, pesanan otomatis dibatalkan.</p>
                                    
                                    <div class="mb-2">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="payment_provider" id="bank_bca" value="Bank BCA">
                                            <label class="form-check-label" for="bank_bca">
                                                Bank BCA <br>
                                                <small class="text-muted">No. Rek: 1234567890 a.n Admin Toko</small>
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="payment_provider" id="bank_bri" value="Bank BRI">
                                            <label class="form-check-label" for="bank_bri">
                                                Bank BRI <br>
                                                <small class="text-muted">No. Rek: 0987654321 a.n Admin Toko</small>
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="payment_provider" id="bank_mandiri" value="Bank Mandiri">
                                            <label class="form-check-label" for="bank_mandiri">
                                                Bank Mandiri <br>
                                                <small class="text-muted">No. Rek: 1122334455 a.n Admin Toko</small>
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="payment_provider" id="wallet_dana" value="DANA">
                                            <label class="form-check-label" for="wallet_dana">
                                                DANA <br>
                                                <small class="text-muted">No. HP: 08123456789 a.n Admin Toko</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rincian Pembayaran -->
                <div class="card shadow-sm border-0 sticky-top" style="top: 6rem; z-index: 10;">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0">Rincian Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal Produk</span>
                            <span class="fw-bold">Rp <?= number_format($data['total']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal Pengiriman</span>
                            <span class="fw-bold" id="displayShippingCost">Rp 15.000</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold h5 mb-0">Total Pembayaran</span>
                            <span class="fw-bold h5 mb-0 text-success" id="displayGrandTotal">Rp 0</span>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded shadow-lg btn-checkout">
                            BUAT PESANAN
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- Modal Ganti Alamat -->
<div class="modal fade" id="changeAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Alamat Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <?php foreach($data['all_addresses'] as $addr): ?>
                        <label class="list-group-item list-group-item-action cursor-pointer">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="selected_address_modal" 
                                               id="addr_<?= $addr['id']; ?>" 
                                               value="<?= $addr['id']; ?>"
                                               data-recipient="<?= $addr['recipient_name']; ?>"
                                               data-phone="<?= $addr['phone']; ?>"
                                               data-address="<?= $addr['address']; ?>"
                                               data-primary="<?= $addr['is_primary']; ?>"
                                               <?= ($addr['id'] == $data['primary_address']['id']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label fw-bold" for="addr_<?= $addr['id']; ?>">
                                            <?= $addr['recipient_name']; ?> 
                                            <span class="fw-normal text-muted">| <?= $addr['phone']; ?></span>
                                        </label>
                                    </div>
                                    <p class="mb-1 ms-4 small text-muted"><?= $addr['address']; ?></p>
                                    <?php if($addr['is_primary']): ?>
                                        <span class="badge bg-outline-primary text-primary border border-primary ms-4">Utama</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= BASEURL; ?>/profile/address" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Kelola / Tambah Alamat
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmAddressChange">Pilih Alamat</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Logic for updating address from modal
    document.getElementById('confirmAddressChange').addEventListener('click', function() {
        const selectedRadio = document.querySelector('input[name="selected_address_modal"]:checked');
        if(selectedRadio) {
            const recipient = selectedRadio.getAttribute('data-recipient');
            const phone = selectedRadio.getAttribute('data-phone');
            const address = selectedRadio.getAttribute('data-address');
            const isPrimary = selectedRadio.getAttribute('data-primary');

            // Update display
            document.getElementById('displayRecipient').innerText = recipient + ' (' + phone + ')';
            document.getElementById('displayAddress').innerText = address;
            
            const badge = document.getElementById('displayBadge');
            if(isPrimary == 1) {
                badge.className = 'badge bg-success mt-2';
                badge.innerText = 'Utama';
                badge.style.display = 'inline-block';
            } else {
                badge.className = 'badge bg-secondary mt-2';
                badge.innerText = 'Terpilih';
                badge.style.display = 'inline-block';
            }

            // Update hidden inputs
            document.getElementById('formAddress').value = address;
            document.getElementById('formRecipient').value = recipient;
            document.getElementById('formPhone').value = phone;

            // Close modal
            var myModalEl = document.getElementById('changeAddressModal');
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        }
    });

    // Existing payment logic...
    function togglePaymentDetails() {
        const transferRadio = document.getElementById('payment_transfer');
        const transferDetails = document.getElementById('transfer_details');
        
        if (transferRadio.checked) {
            transferDetails.style.display = 'block';
        } else {
            transferDetails.style.display = 'none';
        }
    }

    // Add event listener to other payment methods to hide transfer details
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value !== 'transfer') {
                document.getElementById('transfer_details').style.display = 'none';
            }
        });
    });

    // Update total when shipping changes
    document.querySelectorAll('input[name="shipping_courier_select"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const cost = parseInt(this.getAttribute('data-cost'));
            const name = this.getAttribute('data-name');
            const totalProduct = <?= $data['total']; ?>;
            
            // Update display
            document.getElementById('displayShippingCost').innerText = 'Rp ' + cost.toLocaleString('id-ID');
            document.getElementById('displayGrandTotal').innerText = 'Rp ' + (totalProduct + cost).toLocaleString('id-ID');
            
            // Update hidden inputs
            document.getElementById('shipping_cost').value = cost;
            document.getElementById('shipping_courier').value = name;
        });
    });

    // Initialize total on load
    window.addEventListener('load', function() {
        const initialCost = 15000;
        const totalProduct = <?= $data['total']; ?>;
        document.getElementById('displayGrandTotal').innerText = 'Rp ' + (totalProduct + initialCost).toLocaleString('id-ID');
    });
</script>
