<?php

class Home extends Controller {
    public function index() {
        $data['judul'] = 'Home';
        // Get latest 4 products for featured section
        $data['featured_products'] = $this->model('Product_model')->getAllProducts(); 
        // Note: getAllProducts fetches all, for production we should have limit. 
        // For now, we slice in view or add limit to model. Let's slice in view for simplicity.
        
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
