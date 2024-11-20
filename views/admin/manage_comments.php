<?php
include('../../commons/config.php');
include('../../commons/function.php');

// Xử lý xóa bình luận
if (isset($_GET['delete'])) {
    $comments_id = $_GET['delete'];
    $sql = "DELETE FROM comments WHERE comments_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $comments_id);
    if ($stmt->execute()) {
        $success = 'Xóa bình luận thành công';
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
    <title>QUẢN LÝ BÌNH LUẬN</title>
    <link rel="stylesheet" href="../../css/admin/adminDashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <h2>QUẢN LÝ BÌNH LUẬN</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_users.php">QUẢN LÝ NGƯỜI DÙNG</a></li>
                <li><a href="#">QUẢN LÝ ĐƠN HÀNG</a></li>
                <li><a href="#">THỐNG KÊ VÀ BÁO CÁO</a></li>
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

            <div id="list-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID BÌNH LUẬN</th>
                            <th>NỘI DUNG BÌNH LUẬN</th>
                            <th>ID SẢN PHẨM</th>
                            <th>ID NGƯỜI DÙNG</th>
                            <th>THỜI GIAN TẠO</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Lấy tất cả bình luận từ cơ sở dữ liệu
                        $sql = "SELECT * FROM comments";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['comments_id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                                echo "<td>" . $row['products_id'] . "</td>";
                                echo "<td>" . $row['users_id'] . "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                                echo "<td>
                                        <a href='manage_comments.php?delete=" . $row['comments_id'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xoá bình luận này?\");'>Xoá</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Không có bình luận nào.</td></tr>";
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