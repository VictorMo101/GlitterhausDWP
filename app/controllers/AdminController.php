<?php
class AdminController {
    private $admin;

    public function __construct($admin) {
        $this->admin = $admin;
    }

    public function admin() {
        if (!is_admin()) {
            redirect_to('index.php?page=home');
        }

        require_once __DIR__ . "/../views/admin/adminDashboard.php";
    }

    public function adminAbout() {
        if (!is_admin()) {
            redirect_to('index.php?page=home');
        }

        require_once __DIR__ . "/../views/admin/adminAbout.php";
    }
}