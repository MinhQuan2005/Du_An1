<?php
include('../../commons/config.php');
include('../../commons/function.php');

$error = '';
$success = '';

// Xử lý thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $categories_id = $_POST['categories_id'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    
    $views = 0;

    if ($image) {
        // Di chuyển file hình ảnh đến thư mục img
        move_uploaded_file($image_tmp, "../img/" . $image);
    }

    // Kiểm tra các trường bắt buộc
    if (empty($name) || empty($price) || empty($categories_id)) {
        $error = 'Các trường không được để trống';
    } else {
        $sql = "INSERT INTO products (name, price, categories_id, description, image, views) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdissi", $name, $price, $categories_id, $description, $image, $views);
        if ($stmt->execute()) {
            $success = 'Thêm sản phẩm thành công';
        } else {
            $error = 'Lỗi khi thêm sản phẩm';
        }
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $products_id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE products_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $products_id);
    if ($stmt->execute()) {
        $success = 'Xóa sản phẩm thành công';
    } else {
        $error = 'Lỗi khi xóa sản phẩm';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ SẢN PHẨM</title>
    <link rel="stylesheet" href="../../css/admin/adminDashboard.css">
    <script>
        function toggleProductList() {
            var listContainer = document.getElementById('list-container');
            if (listContainer.style.display === 'none') {
                listContainer.style.display = 'block';
            } else {
                listContainer.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <div class="dashboard-container">
        <h2>QUẢN LÝ SẢN PHẨM</h2>
        <div class="menu">
            <ul>
                <li><a href="../admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="#">QUẢN LÝ NGƯỜI DÙNG</a></li>
                <li><a href="../admin/manage_comments.php">QUẢN LÝ BÌNH LUẬN</a></li>
                <li><a href="#">QUẢN LÝ ĐƠN HÀNG</a></li>
                <li><a href="#">THỐNG KÊ VÀ BÁO CÁO</a></li>
                <li><a href="../../account/logout.php">ĐĂNG XUẤT</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="form-container">
                <?php if ($error) : ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success) : ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form action="manage_products.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">TÊN SẢN PHẨM</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">ĐƠN GIÁ</label>
                        <input type="text" name="price" id="price" required>
                    </div>
                    <div class="form-group">
                        <label for="image">HÌNH ẢNH</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <label for="categories_id">LOẠI HÀNG</label>
                        <select id="categories_id" name="categories_id" required>
                            <option value="">Chọn loại hàng</option>
                            <?php
                            $sql = "SELECT * FROM categories";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['categories_id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">MÔ TẢ</label>
                        <textarea name="description" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit">Thêm mới</button>
                        <button type="reset">Nhập lại</button>
                        <button type="button" onclick="toggleProductList()">Danh sách</button>
                    </div>
                </form>
            </div>

            <div id="list-container" style="display: none;" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID SẢN PHẨM</th>
                            <th>TÊN SẢN PHẨM</th>
                            <th>MÔ TẢ</th>
                            <th>ĐƠN GIÁ</th>
                            <th>LOẠI HÀNG</th>
                            <th>HÌNH ẢNH</th>
                            <th>LƯỢT XEM</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM products";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['products_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['categories_id']) . "</td>";
                                echo "<td><img src='../img/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' width='50'></td>";
                                echo "<td>" . htmlspecialchars($row['views']) . "</td>";
                                echo "<td>
                                        <a href='update_manage_products.php?id=" . htmlspecialchars($row['products_id']) . "'>Sửa</a>
                                        <a href='manage_products.php?delete=" . htmlspecialchars($row['products_id']) . "' onclick='return confirm(\"Bạn có chắc chắn muốn xoá sản phẩm này?\")'>Xoá</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Không có sản phẩm nào.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php $conn->close(); ?>