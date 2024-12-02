<?php
include('../../commons/config.php');
include('../../commons/function.php');

// Xử lý lựa chọn của người dùng
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'month';

// Truy vấn doanh thu theo lựa chọn chỉ tính các đơn hàng đã giao thành công
if ($filter == 'day') {
    $query = "SELECT DATE(o.order_date) AS order_day, SUM(p.price) AS revenue
              FROM orders o
              JOIN products p ON o.products_id = p.products_id
              WHERE o.status = 'Đã giao thành công'
              GROUP BY DATE(o.order_date)";
} elseif ($filter == 'year') {
    $query = "SELECT YEAR(o.order_date) AS order_year, SUM(p.price) AS revenue
              FROM orders o
              JOIN products p ON o.products_id = p.products_id
              WHERE o.status = 'Đã giao thành công'
              GROUP BY YEAR(o.order_date)";
} else {
    $query = "SELECT MONTH(o.order_date) AS order_month, SUM(p.price) AS revenue
              FROM orders o
              JOIN products p ON o.products_id = p.products_id
              WHERE o.status = 'Đã giao thành công'
              GROUP BY MONTH(o.order_date)";
}

$result = $conn->query($query);

$salesData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $salesData[] = $row;
    }
}

// Truy vấn top sản phẩm bán chạy theo filter chỉ tính các đơn hàng đã giao thành công
$topProductsQuery = "";
if ($filter == 'day') {
    $topProductsQuery = "SELECT p.name, COUNT(o.products_id) AS quantity
                         FROM orders o
                         JOIN products p ON o.products_id = p.products_id
                         WHERE o.status = 'Đã giao thành công' AND DATE(o.order_date) = CURDATE()
                         GROUP BY p.name
                         ORDER BY quantity DESC
                         LIMIT 5";
} elseif ($filter == 'year') {
    $topProductsQuery = "SELECT p.name, COUNT(o.products_id) AS quantity
                         FROM orders o
                         JOIN products p ON o.products_id = p.products_id
                         WHERE o.status = 'Đã giao thành công' AND YEAR(o.order_date) = YEAR(CURDATE())
                         GROUP BY p.name
                         ORDER BY quantity DESC
                         LIMIT 5";
} else {
    $topProductsQuery = "SELECT p.name, COUNT(o.products_id) AS quantity
                         FROM orders o
                         JOIN products p ON o.products_id = p.products_id
                         WHERE o.status = 'Đã giao thành công' AND MONTH(o.order_date) = MONTH(CURDATE())
                         GROUP BY p.name
                         ORDER BY quantity DESC
                         LIMIT 5";
}

$topProductsResult = $conn->query($topProductsQuery);

$topProducts = [];
if ($topProductsResult->num_rows > 0) {
    while ($row = $topProductsResult->fetch_assoc()) {
        $topProducts[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THỐNG KÊ & BÁO CÁO</title>
    <link rel="stylesheet" href="../../css/admin/adminDashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <h2>THỐNG KÊ & BÁO CÁO</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_users.php">QUẢN LÝ NGƯỜI DÙNG</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_comments.php">QUẢN LÝ BÌNH LUẬN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_orders.php">QUẢN LÝ ĐƠN HÀNG</a></li>
                <li><a href="../../../Du an 1_Nhom 4/account/logout.php">ĐĂNG XUẤT</a></li>
            </ul>
        </div>

        <form method="POST">
            <label for="filter">Bộ lọc:</label>
            <select name="filter" id="filter" onchange="this.form.submit()">
                <option value="month" <?php echo ($filter == 'month') ? 'selected' : ''; ?>>Doanh thu theo tháng</option>
                <option value="day" <?php echo ($filter == 'day') ? 'selected' : ''; ?>>Doanh thu theo ngày</option>
                <option value="year" <?php echo ($filter == 'year') ? 'selected' : ''; ?>>Doanh thu theo năm</option>
            </select>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th><?php echo ($filter == 'day') ? 'Ngày' : (($filter == 'month') ? 'Tháng' : 'Năm'); ?></th>
                        <th>Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salesData as $data): ?>
                        <tr>
                            <td><?php echo ($filter == 'day') ? $data['order_day'] : (($filter == 'month') ? 'Tháng ' . $data['order_month'] : $data['order_year']); ?></td>
                            <td><?php echo number_format($data['revenue'], 0, ',', '.'); ?> VND</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>