<?php
class productController {
    private $productModel;

    public function __construct($productModel) {
        $this->productModel = $productModel;
    }

    // public function index() {
    //     $popularProducts = $this->productModel->getPopularProducts();
    //     $menProducts = $this->productModel->getProductsByCategory(1);
    //     $womenProducts = $this->productModel->getProductsByCategory(2);
    //     $kidsProducts = $this->productModel->getProductsByCategory(3);
    //     require './views/client/dashboard.php'; 
    // }

    public function index() {
        // Kiểm tra nếu có giá trị tìm kiếm từ người dùng (thông qua GET hoặc POST)
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        // var_dump($search);
        // die();
        // Nếu có giá trị tìm kiếm, sử dụng phương thức getBySearch để lấy sản phẩm theo tên
        if ($search) {
            $popularProducts = $this->productModel->getBySearch($search);
        } else {
            // Nếu không có giá trị tìm kiếm, lấy sản phẩm phổ biến mặc định
            $popularProducts = $this->productModel->getPopularProducts();
        }
    
        // Lấy sản phẩm theo danh mục
        $menProducts = $this->productModel->getProductsByCategory(1);
        $womenProducts = $this->productModel->getProductsByCategory(2);
        $kidsProducts = $this->productModel->getProductsByCategory(3);
    
        // Gửi dữ liệu tới view
        require './views/client/dashboard.php'; 
    }
    

    public function showDMnam() {
        $menProducts = $this->productModel->getProductsByCategory(1);
        require_once './views/client/damucnam.php';
    }
    public function showDMnu() {
        $womenProducts = $this->productModel->getProductsByCategory(2);
        require_once './views/client/damucnu.php';
    }
    public function showDMtrmeem() {
        $kidsProducts = $this->productModel->getProductsByCategory(3);
        require_once './views/client/damuctreem.php';
    }
}
?>