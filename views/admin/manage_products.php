<?php
include('../../commons/config.php');
include('../../commons/function.php');

$error = '';
$success = '';

// Thêm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $categories_id = $_POST['categories_id'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
    $image_tmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : null;

    $views = 0;

    if ($image) {
        // Di chuyển file hình ảnh đến thư mục uploads
        move_uploaded_file($image_tmp, "../../../Du an 1_Nhom 4/uploads" . $image);
    }

    // Kiểm tra các trường bắt buộc
    if (empty($name) || empty($price) || empty($categories_id) || empty($status)) {
        $error = 'Các trường không được để trống';
    } else {
        $sql = "INSERT INTO products (name, price, categories_id, description, image, views, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdissis", $name, $price, $categories_id, $description, $image, $views, $status);
        if ($stmt->execute()) {
            $success = 'Thêm sản phẩm thành công';
        } else {
            $error = 'Lỗi khi thêm sản phẩm';
        }
    }
}

// Xoá
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

        function editProduct(id, name, price, categories_id, description, status) {
            document.getElementById('product_id').value = id;
            document.getElementById('product_name').value = name;
            document.getElementById('product_price').value = price;
            document.getElementById('product_categories_id').value = categories_id;
            document.getElementById('product_description').value = description;
            document.getElementById('product_status').value = status;
            document.getElementById('productModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeProductModal() {
            document.getElementById('productModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function showDeleteModal(id) {
            document.getElementById('delete_product_id').value = id;
            document.getElementById('deleteModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</head>

<body>
    <div class="dashboard-container">
        <h2>QUẢN LÝ SẢN PHẨM</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_users.php">QUẢN LÝ NGƯỜI DÙNG</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_comments.php">QUẢN LÝ BÌNH LUẬN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_orders.php">QUẢN LÝ ĐƠN HÀNG</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/statistics_reports.php">THỐNG KÊ & BÁO CÁO</a></li>
                <li><a href="../../../Du an 1_Nhom 4/account/logout.php">ĐĂNG XUẤT</a></li>
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
                        <label for="products_id">ID SẢN PHẨM</label>
                        <input type="text" name="products_id" value="auto number" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">TÊN SẢN PHẨM</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">ĐƠN GIÁ</label>
                        <input type="text" name="price" id="price" required>
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
                        <label for="image">HÌNH ẢNH</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <label for="views">LƯỢT XEM</label>
                        <input type="text" name="views" value="auto number" disabled>
                    </div>
                    <div class="form-group">
                        <label for="status">TRẠNG THÁI</label>
                        <select id="status" name="status" required>
                            <option value="">Hiển thị trạng thái</option>
                            <option value="Còn hàng">Còn hàng</option>
                            <option value="Hết hàng">Hết hàng</option>
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
                            <th>TRẠNG THÁI</th>
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
                                echo "<td>" . number_format($row['price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['categories_id']) . "</td>";
                                echo "<td><img src='../../../Du an 1_Nhom 4/uploads/" . htmlspecialchars($row['image']) . "' width='100'></td>";
                                echo "<td>" . htmlspecialchars($row['views']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>
                                        <button onclick='editProduct(" . $row['products_id'] . ", \"" . htmlspecialchars($row['name']) . "\", \"" . htmlspecialchars($row['price']) . "\", \"" . htmlspecialchars($row['categories_id']) . "\", \"" . htmlspecialchars($row['description']) . "\", \"" . htmlspecialchars($row['status']) . "\")'>Sửa</button>
                                        <button onclick='showDeleteModal(" . $row['products_id'] . ")'>Xoá</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>Không có sản phẩm nào.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal sửa sản phẩm -->
    <div id="productModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Cập nhật sản phẩm</h3><br>
        <form method="POST" action="manage_products.php">
            <input type="hidden" name="products_id" id="product_id">
            <div class="form-group">
                <label for="product_name">Tên sản phẩm:</label><br>
                <input type="text" name="name" id="product_name" required>
            </div><br>
            <div class="form-group">
                <label for="product_price">Đơn giá:</label><br>
                <input type="text" name="price" id="product_price" required>
            </div><br>
            <div class="form-group">
                <label for="product_categories_id">Loại hàng:</label><br>
                <select name="categories_id" id="product_categories_id" required>
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                    <option value="3">Trẻ em</option>
                </select>
            </div><br>
            <div class="form-group">
                <label for="product_status">Trạng thái:</label><br>
                <select name="status" id="product_status" required>
                    <option value="Còn hàng">Còn hàng</option>
                    <option value="Hết hàng">Hết hàng</option>
                </select>
            </div><br>
            <div class="form-group">
                <label for="product_description">Mô tả:</label><br>
                <textarea name="description" id="product_description"></textarea>
            </div><br>
            <button type="button" onclick="closeProductModal()">Đóng</button>
            <button type="submit" name="update_product">Lưu</button>
        </form>
    </div>

    <!-- Modal xoá sản phẩm -->
    <div id="deleteModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Xoá sản phẩm</h3><br>
        <p>Bạn có chắc muốn xoá sản phẩm này?</p><br>
        <form method="GET" action="manage_products.php">
            <input type="hidden" name="delete" id="delete_product_id">
            <button type="button" onclick="closeDeleteModal()">Hủy</button>
            <button type="submit">Xác nhận</button>
        </form>
    </div>

    <!-- Overlay -->
    <div id="overlay" onclick="closeProductModal(); closeDeleteModal();" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
</body>

</html>

<?php $conn->close(); ?>