<?php
include('../../commons/config.php');
include('../../commons/function.php');

$error = '';
$success = '';

// Xử lý thêm người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Kiểm tra các trường bắt buộc
    if (empty($username) || empty($email) || empty($password) || empty($name)) {
        $error = 'Các trường không được để trống.';
    } else {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, email, password, name, phone, address, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $username, $email, $password_hashed, $name, $phone, $address, $is_admin);
        if ($stmt->execute()) {
            $success = 'Thêm người dùng thành công.';
        } else {
            $error = 'Lỗi khi thêm người dùng.';
        }
    }
}

// Xử lý xóa người dùng
if (isset($_GET['delete'])) {
    $users_id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE users_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $users_id);
    if ($stmt->execute()) {
        $success = 'Xóa người dùng thành công.';
    } else {
        $error = 'Lỗi khi xóa người dùng.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ NGƯỜI DÙNG</title>
    <link rel="stylesheet" href="../../css/admin/adminDashboard.css">
    <script>
        function toggleUserList() {
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
        <h2>QUẢN LÝ NGƯỜI DÙNG</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_comments.php">QUẢN LÝ BÌNH LUẬN</a></li>
                <li><a href="#">QUẢN LÝ ĐƠN HÀNG</a></li>
                <li><a href="#">THỐNG KÊ VÀ BÁO CÁO</a></li>
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

                <form action="manage_users.php" method="POST">
                    <div class="form-group">
                        <label for="users_id">ID NGƯỜI DÙNG</label>
                        <input type="text" name="users_id" value="auto number" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">HỌ TÊN</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="username">TÊN ĐĂNG NHẬP</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">EMAIL</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">MẬT KHẨU</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">SỐ ĐIỆN THOẠI</label>
                        <input type="text" name="phone" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="address">ĐỊA CHỈ</label>
                        <input type="text" name="address" id="address">
                    </div>
                    <div class="form-group">
                        <label for="is_admin">
                            <input type="checkbox" name="is_admin" id="is_admin"> QUẢN TRỊ VIÊN
                        </label>
                    </div><br>
                    <div class="form-group">
                        <button type="submit">Thêm mới</button>
                        <button type="reset">Nhập lại</button>
                        <button type="button" onclick="toggleUserList()">Danh sách</button>
                    </div>
                </form>
            </div>

            <div id="list-container" style="display: none;" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID NGƯỜI DÙNG</th>
                            <th>HỌ TÊN</th>
                            <th>TÊN ĐĂNG NHẬP</th>
                            <th>EMAIL</th>
                            <th>SỐ ĐIỆN THOẠI</th>
                            <th>ĐỊA CHỈ</th>
                            <th>VAI TRÒ</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['users_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td>" . ($row['is_admin'] == 1 ? 'Admin' : 'Khách') . "</td>";
                                echo "<td>
                                        <a href='update_manage_users.php?id=" . htmlspecialchars($row['users_id']) . "'>Sửa</a>
                                        <a href='manage_users.php?delete=" . htmlspecialchars($row['users_id']) . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này?\");'>Xóa</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Không có người dùng nào.</td></tr>";
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