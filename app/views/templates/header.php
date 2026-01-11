<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['judul']) ? $data['judul'] : 'Home'; ?> - <?= SITENAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= BASEURL; ?>">
                <img src="<?= BASEURL; ?>/assets/img/logo-rinjani-market.png" alt="<?= SITENAME; ?>" height="50" class="me-2">
                <div class="d-flex flex-column">
                    <span class="fw-bold text-success" style="font-size: 1.25rem; line-height: 1;">Rinjani Market</span>
                    <span class="text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">Produk Lokal NTB</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?= (!isset($data['judul']) || $data['judul'] == 'Home') ? 'active fw-semibold' : ''; ?>" href="<?= BASEURL; ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($data['judul']) && $data['judul'] == 'Daftar Produk') ? 'active fw-semibold' : ''; ?>" href="<?= BASEURL; ?>/products">Produk</a>
                    </li>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="<?= BASEURL; ?>/products/cart">
                                <i class="fas fa-shopping-cart"></i>
                                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?= count($_SESSION['cart']); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle btn btn-outline-light text-dark border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if(isset($_SESSION['user_image']) && !empty($_SESSION['user_image'])): ?>
                                    <img src="<?= BASEURL; ?>/assets/img/profiles/<?= $_SESSION['user_image']; ?>" alt="Profile" class="rounded-circle me-1" style="width: 30px; height: 30px; object-fit: cover;" onerror="this.outerHTML='<i class=\'fas fa-user-circle me-1\'></i>'">
                                <?php else: ?>
                                    <i class="fas fa-user-circle me-1"></i>
                                <?php endif; ?>
                                Hi, <?= explode(' ', $_SESSION['user_name'])[0]; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <?php if($_SESSION['user_role'] == 'admin'): ?>
                                    <li><a class="dropdown-item" href="<?= BASEURL; ?>/admin"><i class="fas fa-tachometer-alt me-2 text-muted"></i> Dashboard Admin</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?= BASEURL; ?>/profile"><i class="fas fa-user me-2 text-muted"></i> Akun Saya</a></li>
                                    <li><a class="dropdown-item" href="<?= BASEURL; ?>/products/orders"><i class="fas fa-history me-2 text-muted"></i> Riwayat Pesanan</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= BASEURL; ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-success px-4" href="<?= BASEURL; ?>/auth/login">Masuk</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-success px-4" href="<?= BASEURL; ?>/auth/register">Daftar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
