<?php
include('../../commons/config.php');
include('../../commons/function.php');

$error = '';
$success = '';

// Thêm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update_category'])) {
    $name = $_POST['name'];

    if (empty($name)) {
        $error = 'Tên danh mục không được để trống';
    } else {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $success = 'Thêm danh mục thành công';
        } else {
            $error = 'Lỗi khi thêm danh mục';
        }
    }
}

// Xoá
if (isset($_GET['delete'])) {
    $categories_id = $_GET['delete'];
    $sql = "DELETE FROM categories WHERE categories_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categories_id);
    if ($stmt->execute()) {
        $success = 'Xóa danh mục thành công';
    } else {
        $error = 'Lỗi khi xóa danh mục';
    }
}

// Sửa
if (isset($_POST['update_category'])) {
    $categories_id = $_POST['categories_id'];
    $name = $_POST['name'];

    if (empty($name)) {
        $error = 'Tên danh mục không được để trống';
    } else {
        $sql = "UPDATE categories SET name=? WHERE categories_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $categories_id);
        if ($stmt->execute()) {
            $success = 'Cập nhật danh mục thành công';
        } else {
            $error = 'Lỗi khi cập nhật danh mục';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ DANH MỤC</title>
    <link rel="stylesheet" href="../../css/admin/adminDashboard.css">
    <script>
        function toggleCategoryList() {
            var listContainer = document.getElementById('list-container');
            if (listContainer.style.display === 'none') {
                listContainer.style.display = 'block';
            } else {
                listContainer.style.display = 'none';
            }
        }

        function editCategory(id, name) {
            document.getElementById('category_id').value = id;
            document.getElementById('category_name').value = name;
            document.getElementById('categoryModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function showDeleteModal(id) {
            document.getElementById('delete_category_id').value = id;
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
        <h2>QUẢN LÝ DANH MỤC</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
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

                <form action="manage_categories.php" method="POST">
                    <div class="form-group">
                        <label for="name">ID DANH MỤC</label>
                        <input type="text" name="categories_id" value="auto number" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">TÊN DANH MỤC</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Thêm mới</button>
                        <button type="reset">Nhập lại</button>
                        <button type="button" onclick="toggleCategoryList()">Danh sách</button>
                    </div>
                </form>
            </div>

            <div id="list-container" style="display: none;" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID DANH MỤC</th>
                            <th>TÊN DANH MỤC</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM categories";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['categories_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>
                                        <button onclick='editCategory(" . $row['categories_id'] . ", \"" . htmlspecialchars($row['name']) . "\")'>Sửa</button>
                                        <button onclick='showDeleteModal(" . $row['categories_id'] . ")'>Xoá</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Không có danh mục nào.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal sửa danh mục -->
    <div id="categoryModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Cập nhật danh mục</h3><br>
        <form method="POST" action="manage_categories.php">
            <input type="hidden" name="categories_id" id="category_id">
            <div class="form-group">
                <label for="category_name">Tên danh mục:</label>
                <input type="text" name="name" id="category_name" required>
            </div>
            <br>
            <button type="button" onclick="closeCategoryModal()">Đóng</button>
            <button type="submit" name="update_category">Lưu</button>
        </form>
    </div>

    <!-- Modal xoá danh mục -->
    <div id="deleteModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Xoá danh mục</h3><br>
        <p>Bạn có chắc muốn xoá danh mục này?</p><br>
        <form method="GET" action="manage_categories.php">
            <input type="hidden" name="delete" id="delete_category_id">
            <button type="button" onclick="closeDeleteModal()">Hủy</button>
            <button type="submit">Xác nhận</button>
        </form>
    </div>

    <!-- Overlay -->
    <div id="overlay" onclick="closeCategoryModal(); closeDeleteModal();" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
</body>

</html>

<?php $conn->close(); ?>