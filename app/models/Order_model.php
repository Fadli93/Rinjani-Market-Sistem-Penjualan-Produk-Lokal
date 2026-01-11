<?php

class Order_model {
    private $table = 'orders';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createOrder($data) {
        $query = "INSERT INTO orders (user_id, total_amount, status, shipping_courier, shipping_cost, payment_method, payment_provider, shipping_address, created_at) 
                  VALUES (:user_id, :total_amount, :status, :shipping_courier, :shipping_cost, :payment_method, :payment_provider, :shipping_address, CURRENT_TIMESTAMP)";
        $this->db->query($query);
        $this->db->bind('user_id', $data['user_id']);
        $this->db->bind('total_amount', $data['total_amount']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('shipping_courier', $data['shipping_courier']);
        $this->db->bind('shipping_cost', $data['shipping_cost']);
        $this->db->bind('payment_method', $data['payment_method']);
        $this->db->bind('payment_provider', isset($data['payment_provider']) ? $data['payment_provider'] : null);
        $this->db->bind('shipping_address', $data['shipping_address']);
        $this->db->execute();
        return $this->db->lastInsertId();
    }

    public function createOrderItem($data) {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) VALUES (:order_id, :product_id, :quantity, :price, :subtotal)";
        $this->db->query($query);
        $this->db->bind('order_id', $data['order_id']);
        $this->db->bind('product_id', $data['product_id']);
        $this->db->bind('quantity', $data['quantity']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('subtotal', $data['subtotal']);
        $this->db->execute();
        return $this->db->rowCount();
    }
    
    public function getOrdersByUserId($user_id) {
        $this->db->query("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->db->bind('user_id', $user_id);
        return $this->db->resultSet();
    }
    
    public function getAllOrders() {
        $this->db->query("SELECT orders.*, users.name as user_name, users.image as user_image FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getOrderById($id) {
        $this->db->query("SELECT orders.*, users.name as user_name FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getOrderItems($order_id) {
        $this->db->query("SELECT order_items.*, products.name as product_name, products.image as product_image 
                          FROM order_items 
                          JOIN products ON order_items.product_id = products.id 
                          WHERE order_items.order_id = :order_id");
        $this->db->bind('order_id', $order_id);
        return $this->db->resultSet();
    }

    public function deleteOrder($id) {
        // Delete order items first (foreign key constraint usually handles this if ON DELETE CASCADE is set, but to be safe)
        $this->db->query("DELETE FROM order_items WHERE order_id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();

        // Delete order
        $this->db->query("DELETE FROM orders WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateStatus($id, $status) {
        $this->db->query("UPDATE orders SET status = :status WHERE id = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getFilteredOrders($status = null, $month = null, $year = null) {
        $query = "SELECT orders.*, users.name as user_name, users.image as user_image FROM orders JOIN users ON orders.user_id = users.id WHERE 1=1";
        
        if ($status && $status != 'all') {
            $query .= " AND orders.status = :status";
        }
        if ($month && $month != 'all') {
            $query .= " AND MONTH(orders.created_at) = :month";
        }
        if ($year && $year != 'all') {
            $query .= " AND YEAR(orders.created_at) = :year";
        }
        
        $query .= " ORDER BY created_at DESC";
        
        $this->db->query($query);
        
        if ($status && $status != 'all') {
            $this->db->bind('status', $status);
        }
        if ($month && $month != 'all') {
            $this->db->bind('month', $month);
        }
        if ($year && $year != 'all') {
            $this->db->bind('year', $year);
        }
        
        return $this->db->resultSet();
    }

    public function getTotalOrdersCount() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }

    public function getTotalRevenue() {
        $this->db->query("SELECT SUM(total_amount) as total FROM " . $this->table . " WHERE status = 'completed'");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    public function getPendingOrdersCount() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'pending' OR status = 'pending_payment'");
        $result = $this->db->single();
        return $result['total'];
    }

    public function getRecentOrders($limit = 5) {
        $this->db->query("SELECT orders.*, users.name as user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getMonthlyRevenue($year) {
        $this->db->query("SELECT MONTH(created_at) as month, SUM(total_amount) as total FROM " . $this->table . " WHERE status = 'completed' AND YEAR(created_at) = :year GROUP BY MONTH(created_at)");
        $this->db->bind('year', $year);
        return $this->db->resultSet();
    }
}
