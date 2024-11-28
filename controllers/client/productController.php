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