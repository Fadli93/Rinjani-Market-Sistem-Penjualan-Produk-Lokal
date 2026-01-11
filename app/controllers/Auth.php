<?php

class Auth extends Controller {
    public function index() {
        $this->login();
    }

    public function login() {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        $data['judul'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('auth/login', $data);
        $this->view('templates/footer');
    }

    public function prosesLogin() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->model('User_model')->getUserByUsername($_POST['username']);
            
            if($user) {
                if(password_verify($_POST['password'], $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_image'] = $user['image'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    if($user['role'] == 'admin') {
                        header('Location: ' . BASEURL . '/admin');
                    } else {
                        header('Location: ' . BASEURL . '/home');
                    }
                    exit;
                } else {
                    Flasher::setFlash('Password salah', 'gagal login', 'danger');
                    header('Location: ' . BASEURL . '/auth/login');
                    exit;
                }
            } else {
                Flasher::setFlash('Username tidak ditemukan', 'gagal login', 'danger');
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
        }
    }

    public function register() {
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Register';
        $this->view('templates/header', $data);
        $this->view('auth/register', $data);
        $this->view('templates/footer');
    }

    public function prosesRegister() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($_POST['password'] !== $_POST['confirm_password']) {
                Flasher::setFlash('Password tidak cocok', 'gagal registrasi', 'danger');
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            if($this->model('User_model')->tambahDataUser($_POST) > 0) {
                Flasher::setFlash('berhasil', 'ditambahkan, silakan login', 'success');
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            } else {
                Flasher::setFlash('gagal', 'ditambahkan', 'danger');
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }

    public function forgotPassword() {
        $data['judul'] = 'Lupa Password';
        $this->view('templates/header', $data);
        $this->view('auth/forgot_password', $data);
        $this->view('templates/footer');
    }

    public function processForgotPassword() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $user = $this->model('User_model')->getUserByEmail($email);

            if($user) {
                $token = bin2hex(random_bytes(32));
                if($this->model('Reset_model')->addToken($email, $token) > 0) {
                    // Simulasi kirim email
                    $resetLink = BASEURL . '/auth/resetPassword/' . $token;
                    Flasher::setFlash('Link reset password telah dikirim ke email Anda: <br><a href="'.$resetLink.'">Klik disini untuk reset password</a>', '(Simulasi Email)', 'success');
                    header('Location: ' . BASEURL . '/auth/forgotPassword');
                    exit;
                } else {
                    Flasher::setFlash('Gagal', 'membuat token reset', 'danger');
                    header('Location: ' . BASEURL . '/auth/forgotPassword');
                    exit;
                }
            } else {
                Flasher::setFlash('Email tidak terdaftar', 'atau salah', 'danger');
                header('Location: ' . BASEURL . '/auth/forgotPassword');
                exit;
            }
        }
    }

    public function resetPassword($token = null) {
        if(!$token) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $checkToken = $this->model('Reset_model')->getToken($token);
        
        if(!$checkToken) {
            Flasher::setFlash('Token invalid', 'atau kadaluarsa', 'danger');
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $data['judul'] = 'Reset Password';
        $data['token'] = $token;
        $this->view('templates/header', $data);
        $this->view('auth/reset_password', $data);
        $this->view('templates/footer');
    }

    public function processResetPassword() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $_POST['token'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if($password !== $confirm_password) {
                Flasher::setFlash('Password', 'tidak cocok', 'danger');
                header('Location: ' . BASEURL . '/auth/resetPassword/' . $token);
                exit;
            }

            if(strlen($password) < 6) {
                Flasher::setFlash('Password', 'minimal 6 karakter', 'danger');
                header('Location: ' . BASEURL . '/auth/resetPassword/' . $token);
                exit;
            }

            $tokenData = $this->model('Reset_model')->getToken($token);
            
            if($tokenData) {
                $user = $this->model('User_model')->getUserByEmail($tokenData['email']);
                if($user) {
                    if($this->model('User_model')->updatePassword($user['id'], $password) >= 0) {
                        $this->model('Reset_model')->deleteToken($tokenData['email']);
                        Flasher::setFlash('Password berhasil', 'direset, silakan login', 'success');
                        header('Location: ' . BASEURL . '/auth/login');
                        exit;
                    } else {
                        Flasher::setFlash('Gagal', 'mereset password', 'danger');
                        header('Location: ' . BASEURL . '/auth/resetPassword/' . $token);
                        exit;
                    }
                } else {
                    Flasher::setFlash('User', 'tidak ditemukan', 'danger');
                    header('Location: ' . BASEURL . '/auth/login');
                    exit;
                }
            } else {
                Flasher::setFlash('Token invalid', 'atau kadaluarsa', 'danger');
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
        }
    }
}
