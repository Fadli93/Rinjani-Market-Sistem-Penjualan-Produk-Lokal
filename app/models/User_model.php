<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getUserByUsername($username) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);
        return $this->db->single();
    }

    public function getUserByEmail($email) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function updateBio($data) {
        $query = "UPDATE " . $this->table . " SET 
                    name = :name,
                    email = :email,
                    phone = :phone,
                    gender = :gender,
                    birthdate = :birthdate
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('phone', $data['phone']);
        $this->db->bind('gender', $data['gender']);
        $this->db->bind('birthdate', $data['birthdate']);
        $this->db->bind('id', $data['id']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateAddress($id, $address) {
        $query = "UPDATE " . $this->table . " SET address = :address WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('address', $address);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updatePassword($id, $password) {
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('password', password_hash($password, PASSWORD_DEFAULT));
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }


    public function checkPassword($id, $password) {
        $this->db->query('SELECT password FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        $row = $this->db->single();
        
        if($row) {
            return password_verify($password, $row['password']);
        }
        return false;
    }

    public function updateProfilePicture($id, $image) {
        $query = "UPDATE " . $this->table . " SET image = :image WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('image', $image);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function tambahDataUser($data) {
        $query = "INSERT INTO " . $this->table . "
                    (name, username, password, role, created_at)
                    VALUES
                  (:name, :username, :password, :role, CURRENT_TIMESTAMP)";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('username', $data['username']);
        // Hash password
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->bind('password', $password);
        $this->db->bind('role', 'customer'); // Default role

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getTotalCustomersCount() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE role = 'customer'");
        $result = $this->db->single();
        return $result['total'];
    }

    public function getAllUsers() {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function deleteUser($id) {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateUser($data) {
        $query = "UPDATE " . $this->table . " SET 
                    name = :name,
                    username = :username,
                    email = :email,
                    phone = :phone,
                    role = :role
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('phone', $data['phone']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('id', $data['id']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }
}
