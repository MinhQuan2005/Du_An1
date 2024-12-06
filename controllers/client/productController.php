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
    public function search() {
        $search = $_GET['query'] ?? ''; // Lấy từ tham số truy vấn 'query'
        
        // Kiểm tra nếu có giá trị tìm kiếm
        if ($search) {
            $results = $this->productModel->getBySearch($search); // Sử dụng phương thức tìm kiếm trong model
        } else {
            $results = []; // Nếu không có giá trị tìm kiếm, trả về mảng rỗng
        }
    
        // Gửi dữ liệu tới view để hiển thị kết quả
        require './views/client/search_results.php'; // Tạo một view để hiển thị kết quả tìm kiếm
    }
    
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
    public function detailPro($id){
            if (empty($id) || !is_numeric($id)) {
                echo "ID sản phẩm không hợp lệ.";
                return;
            }
            $productOne = $this->productModel->findProductById($id);
            if (!$productOne) {
                echo "Không tìm thấy sản phẩm.";
                return;
            }
            //bình luận
            $comments = $this->productModel->getCommentsByProductId($id);
            require_once './views/client/chitietsp.php';
        }
        //bình luận
        public function addComment() {
            if (!isset($_SESSION['user']['users_id'])) {
                echo "Vui lòng đăng nhập để gửi bình luận.";
                return;
            }
            if (isset($_POST['comment']) && isset($_GET['id'])) {
                $id = $_GET['id'];
                $user_id = $_SESSION['user']['users_id'];
                $comment = $_POST['comment'];

                $this->productModel->addComment($id, $user_id, $comment);
                header("Location:../../../Du an 1_Nhom 4/index.php?act=detailpro&id=". $id);
                exit();
            }
        }
}
?>