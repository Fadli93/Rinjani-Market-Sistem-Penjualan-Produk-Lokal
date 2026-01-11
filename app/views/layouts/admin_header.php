<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= SITENAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8f9fc; overflow-x: hidden; }
        #wrapper { display: flex; }
        #sidebar-wrapper { min-height: 100vh; width: 16rem; margin-left: -16rem; transition: margin .25s ease-out; background: #4e73df; background: linear-gradient(180deg,#4e73df 10%,#224abe 100%); color: white; }
        #sidebar-wrapper .sidebar-heading { padding: 1.5rem 1rem; font-size: 1.2rem; font-weight: bold; text-align: center; color: rgba(255,255,255,0.9); letter-spacing: 0.05rem; }
        #page-content-wrapper { min-width: 100vw; }
        #wrapper.toggled #sidebar-wrapper { margin-left: 0; }
        
        .list-group-item { background: transparent; color: rgba(255,255,255,0.8); border: none; padding: 1rem; font-weight: 600; }
        .list-group-item:hover { background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 0.35rem; margin: 0 1rem; width: auto; }
        .list-group-item.active { background: white; color: #4e73df; border-radius: 0.35rem; margin: 0 1rem; width: auto; }
        .list-group-item i { width: 20px; text-align: center; margin-right: 0.5rem; }
        
        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
            #wrapper.toggled #sidebar-wrapper { margin-left: -16rem; }
        }
        
        /* Topbar */
        .topbar { height: 4.375rem; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); background-color: white; z-index: 10; }
        .card { border: none; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); border-radius: 0.35rem; }
        .card-header { background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: bold; color: #4e73df; }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end" id="sidebar-wrapper">
            <div class="sidebar-heading d-flex align-items-center justify-content-center px-2">
                <img src="<?= BASEURL; ?>/assets/img/logo-rinjani-market.png" alt="Logo" class="bg-white rounded p-1" style="height: 40px;">
                <div class="ms-2 text-start">
                    <div class="fw-bold" style="font-size: 1.1rem; line-height: 1;">ADMIN</div>
                    <div class="fw-bold" style="font-size: 1.1rem; line-height: 1;">PANEL</div>
                </div>
            </div>
            <div class="list-group list-group-flush mt-3">
                <a href="<?= BASEURL; ?>/admin" class="list-group-item list-group-item-action <?= ($data['judul'] == 'Dashboard') ? 'active' : ''; ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
                </a>
                <div class="sidebar-heading text-uppercase text-white-50 fs-6 mt-3 mb-1" style="font-size: 0.75rem !important; padding: 0 1rem;">Master Data</div>
                <a href="<?= BASEURL; ?>/admin/categories" class="list-group-item list-group-item-action <?= ($data['judul'] == 'Kategori') ? 'active' : ''; ?>">
                    <i class="fas fa-fw fa-tags"></i> Kategori
                </a>
                <a href="<?= BASEURL; ?>/admin/products" class="list-group-item list-group-item-action <?= ($data['judul'] == 'Produk') ? 'active' : ''; ?>">
                    <i class="fas fa-fw fa-box"></i> Produk
                </a>
                <div class="sidebar-heading text-uppercase text-white-50 fs-6 mt-3 mb-1" style="font-size: 0.75rem !important; padding: 0 1rem;">Transaksi</div>
                <a href="<?= BASEURL; ?>/admin/orders" class="list-group-item list-group-item-action <?= ($data['judul'] == 'Daftar Pesanan') ? 'active' : ''; ?>">
                    <i class="fas fa-fw fa-shopping-cart"></i> Pesanan
                </a>
                <a href="<?= BASEURL; ?>/admin/reports" class="list-group-item list-group-item-action <?= ($data['judul'] == 'Laporan Transaksi') ? 'active' : ''; ?>">
                    <i class="fas fa-fw fa-chart-line"></i> Laporan
                </a>
                <div class="sidebar-heading text-uppercase text-white-50 fs-6 mt-3 mb-1" style="font-size: 0.75rem !important; padding: 0 1rem;">User</div>
                <a href="<?= BASEURL; ?>/admin/users" class="list-group-item list-group-item-action <?= ($data['judul'] == 'Manajemen User') ? 'active' : ''; ?>">
                    <i class="fas fa-fw fa-users"></i> Users
                </a>
                <a href="<?= BASEURL; ?>/auth/logout" class="list-group-item list-group-item-action text-danger">
                    <i class="fas fa-fw fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top">
                <div class="container-fluid">
                    <button class="btn btn-link text-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>
                    
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold"><?= $_SESSION['user_name']; ?></span>
                                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name=<?= $_SESSION['user_name']; ?>&background=random" width="32" height="32">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= BASEURL; ?>/auth/logout"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid">
