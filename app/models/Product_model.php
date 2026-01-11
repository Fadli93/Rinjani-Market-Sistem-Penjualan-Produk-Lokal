<?php

class Product_model {
    private $table = 'products';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllProducts() {
        $this->db->query('SELECT products.*, categories.name as category_name FROM ' . $this->table . ' JOIN categories ON products.category_id = categories.id ORDER BY products.id DESC');
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT products.*, categories.name as category_name FROM ' . $this->table . ' JOIN categories ON products.category_id = categories.id WHERE products.id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getProductsByCategoryId($categoryId) {
        $this->db->query('SELECT products.*, categories.name as category_name FROM ' . $this->table . ' JOIN categories ON products.category_id = categories.id WHERE products.category_id = :category_id ORDER BY products.id DESC');
        $this->db->bind('category_id', $categoryId);
        return $this->db->resultSet();
    }

    public function getMinMaxPrice() {
        $this->db->query('SELECT MIN(price) as min_price, MAX(price) as max_price FROM ' . $this->table);
        return $this->db->single();
    }

    public function getProductsByFilter($categoryId = null, $maxPrice = null) {
        $query = 'SELECT products.*, categories.name as category_name FROM ' . $this->table . ' JOIN categories ON products.category_id = categories.id';
        $conditions = [];
        
        if ($categoryId) {
            $conditions[] = 'products.category_id = :category_id';
        }
        
        if ($maxPrice) {
            $conditions[] = 'products.price <= :max_price';
        }
        
        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }
        
        $query .= ' ORDER BY products.id DESC';
        
        $this->db->query($query);
        
        if ($categoryId) {
            $this->db->bind('category_id', $categoryId);
        }
        
        if ($maxPrice) {
            $this->db->bind('max_price', $maxPrice);
        }
        
        return $this->db->resultSet();
    }

    public function tambahDataProduct($data) {
        // Upload logic should be in controller usually, but passing file name here
        $query = "INSERT INTO " . $this->table . " 
                  (category_id, name, description, price, stock, image, created_at)
                  VALUES (:category_id, :name, :description, :price, :stock, :image, CURRENT_TIMESTAMP)";
        
        $this->db->query($query);
        $this->db->bind('category_id', $data['category_id']);
        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('stock', $data['stock']);
        $this->db->bind('image', $data['image']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateDataProduct($data) {
        $query = "UPDATE " . $this->table . " SET 
                    category_id = :category_id,
                    name = :name,
                    description = :description,
                    price = :price,
                    stock = :stock";
        
        if(isset($data['image'])) {
            $query .= ", image = :image";
        }
        
        $query .= " WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('category_id', $data['category_id']);
        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('stock', $data['stock']);
        $this->db->bind('id', $data['id']);
        
        if(isset($data['image'])) {
            $this->db->bind('image', $data['image']);
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataProduct($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getTotalProductsCount() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }

    public function getLowStockProducts($threshold = 10) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE stock <= :threshold ORDER BY stock ASC");
        $this->db->bind('threshold', $threshold);
        return $this->db->resultSet();
    }
}
