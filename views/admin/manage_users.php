<?php
include('../../commons/config.php');
include('../../commons/function.php');

// Xoá
if (isset($_GET['delete'])) {
    $users_id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE users_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $users_id);
    if ($stmt->execute()) {
        $success = 'Xóa người dùng thành công';
    } else {
        $error = 'Lỗi khi xóa người dùng';
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
        function showDeleteModal(id) {
            document.getElementById('delete_user_id').value = id;
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
        <h2>QUẢN LÝ NGƯỜI DÙNG</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_comments.php">QUẢN LÝ BÌNH LUẬN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_orders.php">QUẢN LÝ ĐƠN HÀNG</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/statistics_reports.php">THỐNG KÊ & BÁO CÁO</a></li>
                <li><a href="../../../Du an 1_Nhom 4/account/logout.php">ĐĂNG XUẤT</a></li>
            </ul>
        </div>

        <div class="content">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)) : ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div id="list-container" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID NGƯỜI DÙNG</th>
                            <th>HỌ TÊN</th>
                            <th>TÊN ĐĂNG NHẬP</th>
                            <th>EMAIL</th>
                            <th>SỐ ĐIỆN THOẠI</th>
                            <th>ĐỊA CHỈ</th>
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
                                echo "<td>
                                        <button onclick='showDeleteModal(" . $row['users_id'] . ")'>Xoá</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Không có người dùng nào.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal xoá người dùng -->
    <div id="deleteModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Xoá người dùng</h3><br>
        <p>Bạn có chắc muốn xoá người dùng này?</p><br>
        <form method="GET" action="manage_users.php">
            <input type="hidden" name="delete" id="delete_user_id">
            <button type="button" onclick="closeDeleteModal()">Hủy</button>
            <button type="submit">Xác nhận</button>
        </form>
    </div>

    <!-- Overlay -->
    <div id="overlay" onclick="closeDeleteModal();" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
</body>

</html>

<?php $conn->close(); ?>