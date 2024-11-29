<?php
// Kiểm tra nếu có ID danh mục từ URL
if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']); // Lấy ID danh mục và chuyển về kiểu số nguyên

    // Kết nối cơ sở dữ liệu
    require_once "./commons/config.php"; // Đường dẫn đúng tới config.php
    $conn = Database::getConnection();

    // Truy vấn sản phẩm thuộc danh mục này
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Lấy dữ liệu sản phẩm
    $products = $result->fetch_all(MYSQLI_ASSOC);

    // Load view hiển thị sản phẩm
    require_once "./views/category_products.php"; // Đường dẫn đúng tới file view
} else {
    echo "Không tìm thấy danh mục!";
    exit;
}
