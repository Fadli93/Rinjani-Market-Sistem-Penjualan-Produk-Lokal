<style>
    @media print {
        @page { size: auto; margin: 10mm; }
        body { background-color: white !important; font-family: 'Times New Roman', Times, serif; color: black !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        #sidebar-wrapper, .topbar, .btn, .no-print, h3.no-print { display: none !important; }
        #wrapper { display: block !important; }
        #page-content-wrapper { width: 100% !important; margin: 0 !important; padding: 0 !important; min-width: 100% !important; }
        .container-fluid { padding: 0 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
        .card { border: none !important; box-shadow: none !important; background: transparent !important; }
        .card-body { padding: 0 !important; }
        .print-header { display: block !important; margin-bottom: 20px; text-align: center; border-bottom: 2px solid black; padding-bottom: 20px; }
        .print-footer { display: block !important; margin-top: 50px; }
        table { width: 100% !important; border-collapse: collapse !important; font-size: 12pt; }
        table, th, td { border: 1px solid black !important; color: black !important; }
        th { background-color: #e9ecef !important; text-align: center; vertical-align: middle; padding: 10px !important; }
        td { padding: 8px !important; vertical-align: middle; }
        .text-right { text-align: right !important; }
        .badge { border: 1px solid black; color: black !important; background: transparent !important; font-weight: normal; padding: 2px 5px; }
    }
    .print-header, .print-footer { display: none; }
</style>

<div class="print-header">
    <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
        <!-- Logo placeholder if needed -->
        <div style="text-align: center;">
            <h2 style="margin: 0; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;"><?= defined('SITENAME') ? SITENAME : 'SISTEM PENJUALAN ONLINE'; ?></h2>
            <p style="margin: 5px 0 0; font-size: 14px;">Jalan Raya Produk Lokal No. 123, Indonesia</p>
            <p style="margin: 0; font-size: 14px;">Email: admin@tokolokal.com | Telp: 0812-3456-7890</p>
        </div>
    </div>
    <h3 style="margin-top: 20px; font-weight: bold; text-decoration: underline;">LAPORAN TRANSAKSI PENJUALAN</h3>
    <?php 
    $filters = [];
    if(isset($data['filter_status']) && $data['filter_status'] != 'all') {
        $statusLabel = $data['filter_status'];
        if($statusLabel == 'pending_payment') $statusLabel = 'Menunggu Pembayaran';
        $filters[] = 'Status: ' . ucfirst($statusLabel);
    }
    if(isset($data['filter_month']) && $data['filter_month'] != 'all') {
        $months = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
        $filters[] = 'Bulan: ' . $months[$data['filter_month']];
    }
    if(isset($data['filter_year']) && $data['filter_year'] != 'all') $filters[] = 'Tahun: ' . $data['filter_year'];
    
    if(!empty($filters)): ?>
    <p style="margin: 5px 0 0; font-size: 14px; font-weight: bold;"><?= implode(' | ', $filters); ?></p>
    <?php endif; ?>
    <p style="margin: 5px 0 0; font-size: 14px;">Dicetak pada: <?= date('d F Y H:i'); ?></p>
</div>

<div class="row">
    <div class="col-md-12">
        <h3 class="no-print">Laporan Transaksi</h3>
        
        <div class="card mb-3 no-print">
            <div class="card-body">
                <form action="<?= BASEURL; ?>/admin/reports" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Status Pesanan</label>
                        <select name="status" class="form-select">
                            <option value="all">Semua Status</option>
                            <option value="pending" <?= isset($data['filter_status']) && $data['filter_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="pending_payment" <?= isset($data['filter_status']) && $data['filter_status'] == 'pending_payment' ? 'selected' : ''; ?>>Menunggu Pembayaran</option>
                            <option value="completed" <?= isset($data['filter_status']) && $data['filter_status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?= isset($data['filter_status']) && $data['filter_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="month" class="form-select">
                            <option value="all">Semua Bulan</option>
                            <?php
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            foreach($months as $num => $name): ?>
                                <option value="<?= $num; ?>" <?= isset($data['filter_month']) && $data['filter_month'] == $num ? 'selected' : ''; ?>><?= $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="year" class="form-select">
                            <option value="all">Semua Tahun</option>
                            <?php 
                            $startYear = 2026;
                            for($i = $startYear; $i <= $startYear + 5; $i++): ?>
                                <option value="<?= $i; ?>" <?= isset($data['filter_year']) && $data['filter_year'] == $i ? 'selected' : ''; ?>><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1"><i class="fas fa-filter"></i> Filter</button>
                            <a href="<?= BASEURL; ?>/admin/reports" class="btn btn-outline-secondary" title="Reset Filter"><i class="fas fa-undo"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <button onclick="window.print()" class="btn btn-secondary mb-3 no-print"><i class="fas fa-print"></i> Cetak Laporan</button>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Pelanggan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $total_pendapatan = 0;
                        foreach($data['orders'] as $order): 
                            $total_pendapatan += $order['total_amount'];
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                            <td><?= $order['user_name']; ?></td>
                            <td class="text-center">
                                <span class="badge bg-secondary"><?= $order['status']; ?></span>
                            </td>
                            <td class="text-end text-right">Rp <?= number_format($order['total_amount']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end text-right fw-bold">Total Pendapatan</th>
                            <th class="text-end text-right fw-bold">Rp <?= number_format($total_pendapatan); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="print-footer">
            <div style="float: right; text-align: center; width: 200px;">
                <p style="margin-bottom: 80px;">Mengetahui,<br>Administrator</p>
                <p style="font-weight: bold; text-decoration: underline;"><?= $_SESSION['user_name'] ?? 'Admin'; ?></p>
            </div>
        </div>
    </div>
</div>
