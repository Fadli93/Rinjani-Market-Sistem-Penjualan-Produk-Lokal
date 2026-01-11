<?php

class Products extends Controller {
    public function index() {
        $data['judul'] = 'Daftar Produk';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $data['active_category'] = isset($_GET['category']) ? $_GET['category'] : null;
        $data['max_price'] = isset($_GET['price']) ? $_GET['price'] : null;
        
        $priceRange = $this->model('Product_model')->getMinMaxPrice();
        $data['min_price_limit'] = $priceRange['min_price'] ?? 0;
        $data['max_price_limit'] = $priceRange['max_price'] ?? 1000000;
        
        // Use filter method instead of getAllProducts
        $data['products'] = $this->model('Product_model')->getProductsByFilter($data['active_category'], $data['max_price']);
        
        $this->view('templates/header', $data);
        $this->view('products/index', $data);
        $this->view('templates/footer');
    }

    public function category($id) {
        // Redirect to index with query param to unify logic
        header('Location: ' . BASEURL . '/products?category=' . $id);
        exit;
    }

    public function addToCart($id) {
        Middleware::auth(); // Harus login dulu

        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }

        Flasher::setFlash('Item berhasil', 'ditambahkan ke keranjang', 'success');
        header('Location: ' . BASEURL . '/products');
        exit;
    }

    public function cart() {
        Middleware::auth();

        $data['judul'] = 'Keranjang Belanja';
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $data['cart_items'] = [];
        $data['total'] = 0;

        foreach($cart as $id => $qty) {
            $product = $this->model('Product_model')->getProductById($id);
            if($product) {
                $product['qty'] = $qty;
                $product['subtotal'] = $product['price'] * $qty;
                $data['total'] += $product['subtotal'];
                $data['cart_items'][] = $product;
            }
        }

        $this->view('templates/header', $data);
        $this->view('products/cart', $data);
        $this->view('templates/footer');
    }

    public function deleteFromCart($id) {
        if(isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: ' . BASEURL . '/products/cart');
        exit;
    }

    public function clearCart() {
        unset($_SESSION['cart']);
        header('Location: ' . BASEURL . '/products/cart');
        exit;
    }

    public function updateCartQty() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if it's an AJAX request
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            
            $id = $_POST['id'];
            $qty = $_POST['qty'];

            if ($qty > 0) {
                $_SESSION['cart'][$id] = $qty;
            } else {
                unset($_SESSION['cart'][$id]);
            }
            
            if ($isAjax) {
                // Return JSON for AJAX
                $product = $this->model('Product_model')->getProductById($id);
                $subtotal = $product['price'] * $qty;
                
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'subtotal' => $subtotal,
                    'qty' => $qty
                ]);
                exit;
            }
        }
        header('Location: ' . BASEURL . '/products/cart');
        exit;
    }

    public function deleteSelectedCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_items'])) {
            foreach ($_POST['selected_items'] as $id) {
                if (isset($_SESSION['cart'][$id])) {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
        header('Location: ' . BASEURL . '/products/cart');
        exit;
    }

    public function checkout() {
        Middleware::auth();
        
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if(empty($cart)) {
            header('Location: ' . BASEURL . '/products');
            exit;
        }

        // Get selected items if provided via POST (from cart checkbox)
        $selected_items = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_items'])) {
            $selected_items = $_POST['selected_items'];
        } else {
            // Default to all items if not specified (backward compatibility)
            $selected_items = array_keys($cart);
        }

        if (empty($selected_items)) {
            Flasher::setFlash('Pilih produk', 'untuk dicheckout', 'warning');
            header('Location: ' . BASEURL . '/products/cart');
            exit;
        }

        // Check if user has primary address
        $primaryAddress = $this->model('Address_model')->getPrimaryAddress($_SESSION['user_id']);
        $user = $this->model('User_model')->getUserById($_SESSION['user_id']); // Keep this for other profile data

        // Validasi Nomor Telepon (Wajib untuk checkout)
        if (empty($user['phone'])) {
            Flasher::setFlash('Nomor Telepon', 'wajib diisi untuk melanjutkan pesanan. Mohon lengkapi data profil Anda.', 'warning');
            $_SESSION['checkout_redirect'] = true;
            header('Location: ' . BASEURL . '/profile');
            exit;
        }

        if (!$primaryAddress) {
            Flasher::setFlash('Alamat pengiriman', 'belum diatur. Mohon tambahkan alamat terlebih dahulu.', 'warning');
            
            // Set redirect intention
            $_SESSION['checkout_redirect'] = true;
            header('Location: ' . BASEURL . '/profile/address');
            exit;
        }

        // Prepare data for view
        $data['judul'] = 'Checkout';
        $data['primary_address'] = $primaryAddress;
        $data['all_addresses'] = $this->model('Address_model')->getAllAddresses($_SESSION['user_id']); // For selection modal
        $data['total'] = 0;
        $data['items_to_checkout'] = [];

        foreach($selected_items as $id) {
            if (isset($cart[$id])) {
                $qty = $cart[$id];
                $product = $this->model('Product_model')->getProductById($id);
                if($product) {
                    $subtotal = $product['price'] * $qty;
                    $data['total'] += $subtotal;
                    $data['items_to_checkout'][] = [
                        'id' => $id,
                        'qty' => $qty,
                        'product' => $product,
                        'subtotal' => $subtotal
                    ];
                }
            }
        }
        
        $this->view('templates/header', $data);
        $this->view('products/checkout', $data);
        $this->view('templates/footer');
    }

    public function processOrder() {
        Middleware::auth();
        
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ' . BASEURL . '/products/cart');
            exit;
        }

        $items = json_decode($_POST['items'], true);
        if (empty($items)) {
            Flasher::setFlash('Terjadi kesalahan', 'data produk tidak valid', 'danger');
            header('Location: ' . BASEURL . '/products/cart');
            exit;
        }

        $shipping_courier = $_POST['shipping_courier'];
        $shipping_cost = $_POST['shipping_cost'];
        $payment_method = $_POST['payment_method'];
        $payment_provider = isset($_POST['payment_provider']) ? $_POST['payment_provider'] : null;
        $shipping_address = $_POST['address'];
        
        $total_product = 0;
        foreach($items as $item) {
            $total_product += $item['subtotal'];
        }
        
        $total_amount = $total_product + $shipping_cost;
        
        $status = 'pending';
        if ($payment_method == 'transfer') {
            $status = 'pending_payment'; // Status khusus untuk transfer
        }

        $orderData = [
            'user_id' => $_SESSION['user_id'],
            'total_amount' => $total_amount,
            'status' => $status,
            'shipping_courier' => $shipping_courier,
            'shipping_cost' => $shipping_cost,
            'payment_method' => $payment_method,
            'payment_provider' => $payment_provider,
            'shipping_address' => $shipping_address
        ];

        $order_id = $this->model('Order_model')->createOrder($orderData);

        if($order_id) {
            foreach($items as $item) {
                $itemData = [
                    'order_id' => $order_id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['product']['price'],
                    'subtotal' => $item['subtotal']
                ];
                $this->model('Order_model')->createOrderItem($itemData);
                
                // Remove only checked out items from cart
                if(isset($_SESSION['cart'][$item['id']])) {
                    unset($_SESSION['cart'][$item['id']]);
                }
            }
            
            Flasher::setFlash('Pesanan berhasil', 'dibuat', 'success');
            header('Location: ' . BASEURL . '/products/orderDetail/' . $order_id); 
        } else {
            Flasher::setFlash('Gagal', 'checkout', 'danger');
            header('Location: ' . BASEURL . '/products/cart');
        }
        exit;
    }

    public function orderDetail($id) {
        Middleware::auth();
        $data['judul'] = 'Detail Pesanan';
        $data['order'] = $this->model('Order_model')->getOrderById($id);
        
        // Security check: Ensure order belongs to logged-in user
        if (!$data['order'] || $data['order']['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASEURL . '/products/orders');
            exit;
        }
        
        $data['order_items'] = $this->model('Order_model')->getOrderItems($id);
        
        $this->view('templates/header', $data);
        $this->view('products/order_detail', $data);
        $this->view('templates/footer');
    }
    
    public function orders() {
        Middleware::auth();
        $data['judul'] = 'Riwayat Pesanan';
        $orders = $this->model('Order_model')->getOrdersByUserId($_SESSION['user_id']);
        
        foreach($orders as &$order) {
            $items = $this->model('Order_model')->getOrderItems($order['id']);
            $order['items'] = $items;
            $order['first_item'] = !empty($items) ? $items[0] : null;
            $order['total_items'] = 0;
            foreach($items as $item) {
                $order['total_items'] += $item['quantity'];
            }
            
            // Calculate estimation based on address
            $order['estimation'] = $this->calculateEstimation($order['shipping_address']);
        }
        $data['orders'] = $orders;
        
        $this->view('templates/header', $data);
        $this->view('products/orders', $data);
        $this->view('templates/footer');
    }

    private function calculateEstimation($address) {
        $address = strtolower($address);
        // Simulasi logika estimasi berdasarkan lokasi
        if (strpos($address, 'jakarta') !== false || strpos($address, 'jabodetabek') !== false) {
            return '1-2 Hari';
        } elseif (strpos($address, 'jawa') !== false || strpos($address, 'bandung') !== false || strpos($address, 'surabaya') !== false) {
            return '2-3 Hari';
        } elseif (strpos($address, 'bali') !== false || strpos($address, 'lombok') !== false || strpos($address, 'ntb') !== false) {
            return '2-4 Hari';
        } elseif (strpos($address, 'sumatera') !== false || strpos($address, 'kalimantan') !== false || strpos($address, 'sulawesi') !== false) {
            return '3-5 Hari';
        } else {
            return '3-7 Hari';
        }
    }
}
