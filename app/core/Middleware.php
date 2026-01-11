<?php

class Middleware {
    public static function auth() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public static function admin() {
        self::auth();
        if($_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASEURL . '/home');
            exit;
        }
    }
}
