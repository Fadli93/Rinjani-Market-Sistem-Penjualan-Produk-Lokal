<?php

class Profile extends Controller {
    public function index() {
        Middleware::auth();
        
        $data['judul'] = 'Profil Saya';
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['active_tab'] = 'profile';
        $data['active_sub_tab'] = 'profile';
        
        $this->view('templates/header', $data);
        $this->view('profile/index', $data);
        $this->view('templates/footer');
    }

    public function address() {
        Middleware::auth();
        
        $data['judul'] = 'Alamat Saya';
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['addresses'] = $this->model('Address_model')->getAllAddresses($_SESSION['user_id']);
        $data['active_tab'] = 'profile';
        $data['active_sub_tab'] = 'address';
        
        $this->view('templates/header', $data);
        $this->view('profile/address', $data);
        $this->view('templates/footer');
    }

    public function addAddress() {
        Middleware::auth();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST['user_id'] = $_SESSION['user_id'];
            
            // Get user data for recipient name and phone if not provided
            $user = $this->model('User_model')->getUserById($_SESSION['user_id']);
            
            if (!isset($_POST['recipient_name']) || empty($_POST['recipient_name'])) {
                $_POST['recipient_name'] = $user['name'];
            }
            
            if (!isset($_POST['phone']) || empty($_POST['phone'])) {
                $_POST['phone'] = $user['phone'];
            }

            if($this->model('Address_model')->addAddress($_POST) > 0) {
                Flasher::setFlash('Alamat berhasil', 'ditambahkan', 'success');
                
                if(isset($_SESSION['checkout_redirect'])) {
                    unset($_SESSION['checkout_redirect']);
                    header('Location: ' . BASEURL . '/products/checkout');
                    exit;
                }
            } else {
                Flasher::setFlash('Gagal', 'menambahkan alamat', 'danger');
            }
            header('Location: ' . BASEURL . '/profile/address');
            exit;
        }
    }

    public function updateAddress() {
        Middleware::auth();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST['user_id'] = $_SESSION['user_id'];
            
            if($this->model('Address_model')->updateAddress($_POST) >= 0) {
                Flasher::setFlash('Alamat berhasil', 'diperbarui', 'success');
            } else {
                Flasher::setFlash('Gagal', 'memperbarui alamat', 'danger');
            }
            header('Location: ' . BASEURL . '/profile/address');
            exit;
        }
    }

    public function setPrimaryAddress($id) {
        Middleware::auth();
        
        if($this->model('Address_model')->setPrimary($id, $_SESSION['user_id']) > 0) {
            Flasher::setFlash('Alamat utama', 'berhasil diubah', 'success');
        } else {
            Flasher::setFlash('Gagal', 'mengubah alamat utama', 'danger');
        }
        header('Location: ' . BASEURL . '/profile/address');
        exit;
    }

    public function deleteAddress($id) {
        Middleware::auth();
        
        if($this->model('Address_model')->deleteAddress($id, $_SESSION['user_id']) > 0) {
            Flasher::setFlash('Alamat berhasil', 'dihapus', 'success');
        } else {
            Flasher::setFlash('Gagal', 'menghapus alamat', 'danger');
        }
        header('Location: ' . BASEURL . '/profile/address');
        exit;
    }

    public function changePassword() {
        Middleware::auth();
        
        $data['judul'] = 'Ubah Password';
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['active_tab'] = 'profile';
        $data['active_sub_tab'] = 'password';
        
        $this->view('templates/header', $data);
        $this->view('profile/change_password', $data);
        $this->view('templates/footer');
    }

    public function updatePasswordHandler() {
        Middleware::auth();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            
            if(!$this->model('User_model')->checkPassword($_SESSION['user_id'], $currentPassword)) {
                Flasher::setFlash('Password saat ini', 'salah', 'danger');
                header('Location: ' . BASEURL . '/profile/changePassword');
                exit;
            }
            
            if($newPassword !== $confirmPassword) {
                Flasher::setFlash('Konfirmasi password', 'tidak cocok', 'danger');
                header('Location: ' . BASEURL . '/profile/changePassword');
                exit;
            }
            
            if(strlen($newPassword) < 6) {
                Flasher::setFlash('Password baru', 'minimal 6 karakter', 'danger');
                header('Location: ' . BASEURL . '/profile/changePassword');
                exit;
            }
            
            if($this->model('User_model')->updatePassword($_SESSION['user_id'], $newPassword) >= 0) {
                Flasher::setFlash('Password berhasil', 'diubah', 'success');
                header('Location: ' . BASEURL . '/profile/changePassword');
                exit;
            } else {
                Flasher::setFlash('Gagal', 'mengubah password', 'danger');
                header('Location: ' . BASEURL . '/profile/changePassword');
                exit;
            }
        }
    }

    public function update() {
        Middleware::auth();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST['id'] = $_SESSION['user_id'];
            
            // Handle profile picture upload
            if(isset($_FILES['image']) && $_FILES['image']['error'] != 4) {
                $file = $_FILES['image'];
                $fileName = $file['name'];
                $fileTmp = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                
                $allowed = array('jpg', 'jpeg', 'png');
                
                if(in_array($fileActualExt, $allowed)) {
                    if($fileError === 0) {
                        if($fileSize < 5000000) { // 5MB limit
                            $fileNameNew = "profile_" . $_SESSION['user_id'] . "." . $fileActualExt;
                            $fileDestination = 'assets/img/profiles/' . $fileNameNew;
                            
                            // Create directory if not exists
                            if (!file_exists('assets/img/profiles')) {
                                mkdir('assets/img/profiles', 0777, true);
                            }
                            
                            if(move_uploaded_file($fileTmp, $fileDestination)) {
                                $this->model('User_model')->updateProfilePicture($_SESSION['user_id'], $fileNameNew);
                                $_SESSION['user_image'] = $fileNameNew;
                            } else {
                                Flasher::setFlash('Gagal', 'mengunggah gambar ke server', 'danger');
                                header('Location: ' . BASEURL . '/profile');
                                exit;
                            }
                        } else {
                            Flasher::setFlash('Gagal', 'ukuran gambar terlalu besar (maks 5MB)', 'danger');
                            header('Location: ' . BASEURL . '/profile');
                            exit;
                        }
                    } else {
                        Flasher::setFlash('Gagal', 'terjadi kesalahan saat upload gambar', 'danger');
                        header('Location: ' . BASEURL . '/profile');
                        exit;
                    }
                } else {
                    Flasher::setFlash('Gagal', 'format gambar tidak didukung (gunakan JPG, JPEG, PNG)', 'danger');
                    header('Location: ' . BASEURL . '/profile');
                    exit;
                }
            }

            if($this->model('User_model')->updateBio($_POST) >= 0) {
                // Update session name if changed
                $_SESSION['user_name'] = $_POST['name'];
                
                Flasher::setFlash('Profil berhasil', 'diperbarui', 'success');
                
                if(isset($_SESSION['checkout_redirect'])) {
                    unset($_SESSION['checkout_redirect']);
                    header('Location: ' . BASEURL . '/products/checkout');
                    exit;
                }
                
                header('Location: ' . BASEURL . '/profile');
                exit;
            } else {
                Flasher::setFlash('Gagal', 'memperbarui profil', 'danger');
                header('Location: ' . BASEURL . '/profile');
                exit;
            }
        }
    }
}
