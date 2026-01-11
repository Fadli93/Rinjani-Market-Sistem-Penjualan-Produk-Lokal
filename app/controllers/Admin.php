<?php

class Admin extends Controller {
    public function __construct() {
        Middleware::admin();
    }

    public function index() {
        $data['judul'] = 'Dashboard';
        
        // Fetch Statistics
        $data['total_products'] = $this->model('Product_model')->getTotalProductsCount();
        $data['total_orders'] = $this->model('Order_model')->getTotalOrdersCount();
        $data['total_revenue'] = $this->model('Order_model')->getTotalRevenue();
        $data['pending_orders'] = $this->model('Order_model')->getPendingOrdersCount();
        $data['total_customers'] = $this->model('User_model')->getTotalCustomersCount();
        
        // Recent Orders
        $data['recent_orders'] = $this->model('Order_model')->getRecentOrders(5);
        
        // Low Stock Products
        $data['low_stock_products'] = $this->model('Product_model')->getLowStockProducts(5);
        
        // Monthly Revenue Chart Data
        $monthlyRevenue = $this->model('Order_model')->getMonthlyRevenue(date('Y'));
        $chartData = array_fill(1, 12, 0); // Initialize all months with 0
        foreach ($monthlyRevenue as $row) {
            $chartData[$row['month']] = (int)$row['total'];
        }
        $data['revenue_chart_data'] = array_values($chartData);
        
        $this->view('layouts/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/admin_footer');
    }

    // --- CATEGORIES ---
    public function categories() {
        $data['judul'] = 'Kategori';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function categoryStore() {
        if($this->model('Category_model')->tambahDataCategory($_POST) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    public function categoryEdit($id) {
        $data['judul'] = 'Edit Kategori';
        $data['category'] = $this->model('Category_model')->getCategoryById($id);
        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/edit', $data);
        $this->view('layouts/admin_footer');
    }

    public function categoryUpdate() {
        if($this->model('Category_model')->updateDataCategory($_POST) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            Flasher::setFlash('gagal', 'diubah', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    public function categoryDelete($id) {
        if($this->model('Category_model')->hapusDataCategory($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    // --- PRODUCTS ---
    public function products() {
        $data['judul'] = 'Produk';
        $data['products'] = $this->model('Product_model')->getAllProducts();
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function productStore() {
        // Simple File Upload
        $fileName = '';
        if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $fileName = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'assets/img/' . $fileName);
        }

        $_POST['image'] = $fileName;

        if($this->model('Product_model')->tambahDataProduct($_POST) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    public function productEdit($id) {
        $data['judul'] = 'Edit Produk';
        $data['product'] = $this->model('Product_model')->getProductById($id);
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/products/edit', $data);
        $this->view('layouts/admin_footer');
    }

    public function productUpdate() {
        $fileName = $_POST['oldImage']; // Default to old image
        
        if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $fileName = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'assets/img/' . $fileName);
        }

        $_POST['image'] = $fileName;

        if($this->model('Product_model')->updateDataProduct($_POST) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
        } else {
            // Check if 0 rows affected (might be no changes)
            // But usually model returns rowCount. If data is same, rowCount might be 0.
            // Let's assume success or just redirect.
            Flasher::setFlash('info', 'tidak ada perubahan atau gagal', 'info');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }
    
    public function productDelete($id) {
        if($this->model('Product_model')->hapusDataProduct($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/products');
        exit;
    }

    // --- ORDERS ---
    public function orders() {
        $data['judul'] = 'Daftar Pesanan';
        $data['orders'] = $this->model('Order_model')->getAllOrders();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function orderDetail($id) {
        $data['judul'] = 'Detail Pesanan';
        $data['order'] = $this->model('Order_model')->getOrderById($id);
        $data['order_items'] = $this->model('Order_model')->getOrderItems($id);
        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/detail', $data);
        $this->view('layouts/admin_footer');
    }

    public function orderDelete($id) {
        if($this->model('Order_model')->deleteOrder($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/orders');
        exit;
    }

    public function orderUpdateStatus() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];
            
            if($this->model('Order_model')->updateStatus($id, $status) > 0) {
                Flasher::setFlash('Status pesanan', 'berhasil diperbarui', 'success');
            } else {
                Flasher::setFlash('Status pesanan', 'gagal diperbarui', 'danger');
            }
            header('Location: ' . BASEURL . '/admin/orders');
            exit;
        }
    }

    // --- REPORTS ---
    public function reports() {
        $data['judul'] = 'Laporan Transaksi';
        
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $month = isset($_GET['month']) ? $_GET['month'] : null;
        $year = isset($_GET['year']) ? $_GET['year'] : null;
        
        $data['orders'] = $this->model('Order_model')->getFilteredOrders($status, $month, $year);
        
        // Pass filter params to view
        $data['filter_status'] = $status;
        $data['filter_month'] = $month;
        $data['filter_year'] = $year;
        
        $this->view('layouts/admin_header', $data);
        $this->view('admin/reports/index', $data);
        $this->view('layouts/admin_footer');
    }

    // --- USERS MANAGEMENT ---
    public function users() {
        $data['judul'] = 'Manajemen User';
        $data['users'] = $this->model('User_model')->getAllUsers();
        $this->view('layouts/admin_header', $data);
        $this->view('admin/users/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function userEdit($id) {
        $data['judul'] = 'Edit User';
        $data['user'] = $this->model('User_model')->getUserById($id);
        $this->view('layouts/admin_header', $data);
        $this->view('admin/users/edit', $data);
        $this->view('layouts/admin_footer');
    }

    public function userUpdate() {
        $infoChanged = $this->model('User_model')->updateUser($_POST);
        $passChanged = 0;

        if(!empty($_POST['new_password'])) {
            $passChanged = $this->model('User_model')->updatePassword($_POST['id'], $_POST['new_password']);
        }

        if($infoChanged > 0 || $passChanged > 0) {
            Flasher::setFlash('berhasil', 'diupdate', 'success');
        } else {
            Flasher::setFlash('info', 'tidak ada perubahan', 'info');
        }
        header('Location: ' . BASEURL . '/admin/users');
        exit;
    }

    public function userDelete($id) {
        if($this->model('User_model')->deleteUser($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/users');
        exit;
    }
}
