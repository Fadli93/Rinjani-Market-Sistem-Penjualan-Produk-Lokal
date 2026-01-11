<?php

class Address_model {
    private $table = 'user_addresses';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllAddresses($userId) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id = :uid ORDER BY is_primary DESC, created_at DESC');
        $this->db->bind('uid', $userId);
        return $this->db->resultSet();
    }

    public function getAddressById($id, $userId) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id AND user_id = :uid');
        $this->db->bind('id', $id);
        $this->db->bind('uid', $userId);
        return $this->db->single();
    }

    public function getPrimaryAddress($userId) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id = :uid AND is_primary = 1');
        $this->db->bind('uid', $userId);
        $result = $this->db->single();

        // If no primary set, return the first one found
        if (!$result) {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id = :uid LIMIT 1');
            $this->db->bind('uid', $userId);
            $result = $this->db->single();
        }

        return $result;
    }

    public function addAddress($data) {
        // Check if this is the first address, if so make it primary
        $this->db->query('SELECT COUNT(*) as count FROM ' . $this->table . ' WHERE user_id = :uid');
        $this->db->bind('uid', $data['user_id']);
        $count = $this->db->single()['count'];
        
        $isPrimary = ($count == 0) ? 1 : 0;

        $query = "INSERT INTO " . $this->table . " (user_id, recipient_name, phone, address, is_primary) 
                  VALUES (:uid, :name, :phone, :address, :is_primary)";
        
        $this->db->query($query);
        $this->db->bind('uid', $data['user_id']);
        $this->db->bind('name', $data['recipient_name']);
        $this->db->bind('phone', $data['phone']);
        $this->db->bind('address', $data['address']);
        $this->db->bind('is_primary', $isPrimary);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateAddress($data) {
        $query = "UPDATE " . $this->table . " SET 
                    recipient_name = :name,
                    phone = :phone,
                    address = :address
                  WHERE id = :id AND user_id = :uid";
        
        $this->db->query($query);
        $this->db->bind('name', $data['recipient_name']);
        $this->db->bind('phone', $data['phone']);
        $this->db->bind('address', $data['address']);
        $this->db->bind('id', $data['id']);
        $this->db->bind('uid', $data['user_id']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteAddress($id, $userId) {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id = :id AND user_id = :uid');
        $this->db->bind('id', $id);
        $this->db->bind('uid', $userId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function setPrimary($id, $userId) {
        // 1. Set all to 0
        $this->db->query('UPDATE ' . $this->table . ' SET is_primary = 0 WHERE user_id = :uid');
        $this->db->bind('uid', $userId);
        $this->db->execute();

        // 2. Set specific to 1
        $this->db->query('UPDATE ' . $this->table . ' SET is_primary = 1 WHERE id = :id AND user_id = :uid');
        $this->db->bind('id', $id);
        $this->db->bind('uid', $userId);
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}