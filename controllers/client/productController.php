<?php
class productController {
    private $productModel;

    public function __construct($productModel) {
        $this->productModel = $productModel;
    }

    public function index() {
        $popularProducts = $this->productModel->getPopularProducts();
        $menProducts = $this->productModel->getProductsByCategory(1);
        $womenProducts = $this->productModel->getProductsByCategory(2);
        $kidsProducts = $this->productModel->getProductsByCategory(3);
        require './views/client/dashboard.php'; 
    }   
}
?>