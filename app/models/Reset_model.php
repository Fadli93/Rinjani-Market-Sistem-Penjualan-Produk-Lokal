<?php

class Reset_model {
    private $table = 'password_resets';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addToken($email, $token) {
        // Hapus token lama jika ada
        $this->deleteToken($email);
        
        $query = "INSERT INTO " . $this->table . " (email, token) VALUES (:email, :token)";
        $this->db->query($query);
        $this->db->bind('email', $email);
        $this->db->bind('token', $token);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getToken($token) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE token = :token");
        $this->db->bind('token', $token);
        return $this->db->single();
    }

    public function deleteToken($email) {
        $this->db->query("DELETE FROM " . $this->table . " WHERE email = :email");
        $this->db->bind('email', $email);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
