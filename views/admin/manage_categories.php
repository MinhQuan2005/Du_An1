<?php
include('../../commons/config.php');
include('../../commons/function.php');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý thêm hoặc cập nhật danh mục
    if (isset($_POST['add_or_update_category'])) {
        $name = $_POST['name'];
        $id = $_POST['categories_id'] ?? null;

        if (empty($name)) {
            $error = 'Tên loại không được để trống';
        } else {
            if ($id) {
                // Cập nhật danh mục
                $sql = "UPDATE categories SET name = ? WHERE categories_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $name, $id);
                if ($stmt->execute()) {
                    $success = 'Cập nhật loại thành công';
                } else {
                    $error = 'Lỗi khi cập nhật loại';
                }
            } else {
                // Thêm mới danh mục
                $sql = "INSERT INTO categories (name) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $name);
                if ($stmt->execute()) {
                    $success = 'Thêm loại thành công';
                } else {
                    $error = 'Lỗi khi thêm loại';
                }
            }
        }
    }
}

// Xử lý xóa danh mục
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

// Lấy danh sách danh mục
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ DANH MỤC</title>
    <link rel="stylesheet" href="../../css/admin/adminDashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>QUẢN LÝ DANH MỤC</h2>
        <div class="menu">
            <ul>
                <li><a href="../admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="#">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="#">QUẢN LÝ NGƯỜI DÙNG</a></li>
                <li><a href="#">QUẢN LÝ BÌNH LUẬN</a></li>
                <li><a href="#">QUẢN LÝ ĐƠN HÀNG</a></li>
                <li><a href="#">THỐNG KÊ VÀ BÁO CÁO</a></li>
                <li><a href="../../account/logout.php">ĐĂNG XUẤT</a></li>
            </ul>
        </div>
        <div class="content">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <!-- Form thêm hoặc sửa -->
            <form action="manage_categories.php" method="POST">
                <div class="form-group">
                    <label for="categories_id">ID DANH MỤC</label>
                    <input type="text" name="categories_id" id="categories_id" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="name">TÊN DANH MỤC</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <button type="submit" name="add_or_update_category">Lưu</button>
                    <button type="reset" onclick="resetForm()">Nhập lại</button>
                </div>
            </form>

            <!-- Danh sách danh mục -->
            <table>
                <thead>
                    <tr>
                        <th>ID DANH MỤC</th>
                        <th>TÊN DANH MỤC</th>
                        <th>HÀNH ĐỘNG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo $category['categories_id']; ?></td>
                                <td><?php echo $category['name']; ?></td>
                                <td>
                                    <button onclick="editCategory(<?php echo $category['categories_id']; ?>, '<?php echo $category['name']; ?>')">Sửa</button>
                                    <a href="manage_categories.php?delete=<?php echo $category['categories_id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3">Không có danh mục nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function editCategory(id, name) {
            document.getElementById('categories_id').value = id;
            document.getElementById('name').value = name;
        }

        function resetForm() {
            document.getElementById('categories_id').value = '';
            document.getElementById('name').value = '';
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>