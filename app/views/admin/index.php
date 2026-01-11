<div class="row">
    <div class="col-md-12 mb-4">
        <h1 class="h3 mb-2 text-gray-800">Dashboard Overview</h1>
        <p class="mb-4">Selamat datang kembali, <strong><?= $_SESSION['user_name']; ?></strong>! Berikut adalah ringkasan performa toko Anda.</p>
        
        <!-- Statistics Cards -->
        <div class="row">
            <!-- Earnings (Total) Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($data['total_revenue']); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pesanan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['total_orders']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pesanan Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['pending_orders']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pelanggan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['total_customers']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Pendapatan Tahun <?= date('Y'); ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="position: relative; height: 300px;">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pelanggan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['recent_orders'] as $order): ?>
                                    <tr>
                                        <td>#<?= $order['id']; ?></td>
                                        <td><?= $order['user_name']; ?></td>
                                        <td>Rp <?= number_format($order['total_amount']); ?></td>
                                        <td>
                                            <?php 
                                                $badgeClass = 'bg-secondary';
                                                if($order['status'] == 'completed') $badgeClass = 'bg-success';
                                                elseif($order['status'] == 'pending' || $order['status'] == 'pending_payment') $badgeClass = 'bg-warning text-dark';
                                                elseif($order['status'] == 'cancelled') $badgeClass = 'bg-danger';
                                            ?>
                                            <span class="badge <?= $badgeClass; ?>"><?= $order['status']; ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= BASEURL; ?>/admin/orderDetail/<?= $order['id']; ?>" class="btn btn-info btn-sm btn-circle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-2">
                            <a href="<?= BASEURL; ?>/admin/orders" class="small">Lihat Semua Pesanan &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart / Side Content -->
            <div class="col-xl-4 col-lg-5">
                <!-- Low Stock Alert -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Stok Menipis (< 5)</h6>
                    </div>
                    <div class="card-body">
                        <?php if(empty($data['low_stock_products'])): ?>
                            <p class="text-success text-center my-4"><i class="fas fa-check-circle fa-3x mb-3"></i><br>Semua stok aman!</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach($data['low_stock_products'] as $product): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="my-0"><?= $product['name']; ?></h6>
                                        <small class="text-muted">Harga: Rp <?= number_format($product['price']); ?></small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill"><?= $product['stock']; ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="text-center mt-3">
                                <a href="<?= BASEURL; ?>/admin/products" class="btn btn-sm btn-primary">Kelola Stok</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Informasi Sistem</h6>
                    </div>
                    <div class="card-body">
                        <p>Total Produk: <strong><?= $data['total_products']; ?></strong></p>
                        <p>Versi Sistem: <strong>1.0.0</strong></p>
                        <p>Server Time: <strong><?= date('d M Y H:i'); ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: "Pendapatan",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: <?= json_encode($data['revenue_chart_data']); ?>,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 12
                    }
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return 'Rp ' + number_format(value);
                        }
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                },
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + number_format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script>
