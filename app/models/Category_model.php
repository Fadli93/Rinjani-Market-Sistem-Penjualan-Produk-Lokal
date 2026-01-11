<?php

class Category_model {
    private $table = 'categories';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getCategoryById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataCategory($data) {
        $query = "INSERT INTO " . $this->table . " (name, created_at) VALUES (:name, CURRENT_TIMESTAMP)";
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateDataCategory($data) {
        $query = "UPDATE " . $this->table . " SET name = :name WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataCategory($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
