<?php
include('../../commons/config.php');
include('../../commons/function.php');

// Sửa
if (isset($_POST['update_status'])) {
    $orders_id = $_POST['orders_id'];
    $status = $_POST['status'];
    $sql = "UPDATE orders SET status=? WHERE orders_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $orders_id);
    if ($stmt->execute()) {
        $success = 'Cập nhật trạng thái thành công';
    } else {
        $error = 'Có lỗi xảy ra';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ ĐƠN HÀNG</title>
    <link rel="stylesheet" href="../../../Du an 1_Nhom 4/css/admin/adminDashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <h2>QUẢN LÝ ĐƠN HÀNG</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_users.php">QUẢN LÝ NGƯỜI DÙNG</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_comments.php">QUẢN LÝ BÌNH LUẬN</a></li>
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
                            <th>ID ĐƠN HÀNG</th>
                            <th>TÊN KHÁCH HÀNG</th>
                            <th>SỐ ĐIỆN THOẠI</th>
                            <th>EMAIL</th>
                            <th>ĐỊA CHỈ</th>
                            <th>NGÀY ĐẶT HÀNG</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM orders";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['orders_id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td>" . $row['order_date'] . "</td>";
                                echo "<td>
                                        <button onclick='editStatus(" . $row['orders_id'] . ", `" . htmlspecialchars($row['status']) . "`)'>Chi tiết</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>Không có đơn hàng nào.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật trạng thái -->
    <div id="statusModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Cập nhật trạng thái</h3><br>
        <form method="POST" action="">
            <input type="hidden" name="orders_id" id="orders_id">
            <label for="status">Trạng thái:</label>
            <input type="text" name="status" id="status" required>
            <br><br>
            <button type="button" onclick="closeModal()">Đóng</button>
            <button type="submit" name="update_status">Lưu</button>
        </form>
    </div>

    <!-- Overlay để làm mờ nền -->
    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

    <script>
        function editStatus(orderId, currentStatus) {
            // Hiển thị modal và overlay
            document.getElementById('statusModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            // Gán giá trị vào form
            document.getElementById('orders_id').value = orderId;
            document.getElementById('status').value = currentStatus;
        }

        function closeModal() {
            // Ẩn modal và overlay
            document.getElementById('statusModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>

</html>

<?php $conn->close(); ?>