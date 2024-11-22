<?php
include('../../commons/config.php');
include('../../commons/function.php');

// Xoá
if (isset($_GET['delete'])) {
    $orders_id = $_GET['delete'];
    $sql = "DELETE FROM orders WHERE orders_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orders_id);
    if ($stmt->execute()) {
        $success = 'Xóa đơn hàng thành công';
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
                <li><a href="#">THỐNG KÊ & BÁO CÁO</a></li>
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
                            <th>ID NGƯỜI DÙNG</th>
                            <th>ID SẢN PHẨM</th>
                            <th>NGÀY ĐẶT HÀNG</th>
                            <th>TRẠNG THÁI</th>
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
                                echo "<td>" . $row['users_id'] . "</td>";
                                echo "<td>" . $row['products_id'] . "</td>";
                                echo "<td>" . $row['order_date'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>
                                        <a href='manage_orders.php?delete=" . $row['orders_id'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xoá đơn hàng này?\");'>Xoá</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Không có đơn hàng nào.</td></tr>";
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