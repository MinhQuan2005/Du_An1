<?php
include('../../commons/config.php');
include('../../commons/function.php');

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';

if ($order_id <= 0) {
    die("ID đơn hàng không hợp lệ");
}

// Sửa
if (isset($_POST['update_status'])) {
    $ord_details_id = $_POST['ord_details_id'];
    $status = $_POST['status'];
    $sql_update = "UPDATE order_details SET status=? WHERE ord_details_id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $status, $ord_details_id);

    if ($stmt_update->execute()) {
        $success = 'Cập nhật trạng thái thành công';
    } else {
        $error = 'Có lỗi xảy ra trong quá trình cập nhật trạng thái';
    }
}

// Lấy chi tiết đơn hàng
$sql = "SELECT 
            od.ord_details_id, 
            o.orders_id,
            o.name AS customer_name,
            o.phone,
            o.email,
            o.address,
            o.order_date,
            o.status AS order_status,
            od.products_id,
            p.name AS product_name,
            od.quantity,
            od.unit_price,
            od.total_price,
            od.status AS detail_status
        FROM order_details od
        JOIN orders o ON od.orders_id = o.orders_id
        JOIN products p ON od.products_id = p.products_id
        WHERE o.orders_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHI TIẾT ĐƠN HÀNG</title>
    <link rel="stylesheet" href="../../../Du an 1_Nhom 4/css/admin/adminDashboard.css">
    <script>
        function editStatus(ordDetailsId, currentStatus) {
            document.getElementById('statusModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('ord_details_id').value = ordDetailsId;
            document.getElementById('status').value = currentStatus;
        }

        function closeModal() {
            document.getElementById('statusModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</head>

<body>
    <div class="dashboard-container">
        <h2>CHI TIẾT ĐƠN HÀNG</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_users.php">QUẢN LÝ NGƯỜI DÙNG</a></li>
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
                            <th>ID ĐƠN HÀNG</th>
                            <th>TÊN KHÁCH HÀNG</th>
                            <th>SỐ ĐIỆN THOẠI</th>
                            <th>EMAIL</th>
                            <th>ĐỊA CHỈ</th>
                            <th>NGÀY ĐẶT HÀNG</th>
                            <th>TÊN SẢN PHẨM</th>
                            <th>SỐ LƯỢNG</th>
                            <th>ĐƠN GIÁ</th>
                            <th>TỔNG GIÁ</th>
                            <th>TRẠNG THÁI</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['orders_id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td>" . $row['order_date'] . "</td>";
                                echo "<td>" . $row['product_name'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . number_format($row['unit_price']) . "</td>";
                                echo "<td>" . number_format($row['total_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['detail_status']) . "</td>";
                                echo "<td><button onclick='editStatus(" . $row['ord_details_id'] . ", `" . htmlspecialchars($row['detail_status']) . "`)'>Sửa</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12'>Không có chi tiết đơn hàng nào.</td></tr>";
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
            <input type="hidden" name="ord_details_id" id="ord_details_id">
            <label for="status">Trạng thái đơn hàng:</label><br>
            <select name="status" id="status" required>
                <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                <option value="Đã xử lý">Đã xử lý</option>
                <option value="Đã giao hàng">Đã giao hàng</option>
                <option value="Đã giao thành công">Đã giao thành công</option>
                <option value="Đã huỷ">Đã huỷ</option>
            </select><br><br>
            <button type="button" onclick="closeModal()">Đóng</button>
            <button type="submit" name="update_status">Lưu</button>
        </form>
    </div>

    <!-- Overlay -->
    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>