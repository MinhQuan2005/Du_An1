<?php
include('../../commons/config.php');
include('../../commons/function.php');

// Xoá
if (isset($_GET['delete'])) {
    $comments_id = $_GET['delete'];
    $sql = "DELETE FROM comments WHERE comments_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $comments_id);
    if ($stmt->execute()) {
        $success = 'Xóa bình luận thành công';
    } else {
        $error = 'Lỗi khi xoá bình luận';
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
    <script>
        function showDeleteModal(id) {
            document.getElementById('delete_comment_id').value = id;
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
        <h2>QUẢN LÝ BÌNH LUẬN</h2>
        <div class="menu">
            <ul>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/adminDashboard.php">BẢNG ĐIỀU KHIỂN</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_categories.php">QUẢN LÝ DANH MỤC</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_products.php">QUẢN LÝ SẢN PHẨM</a></li>
                <li><a href="../../../Du an 1_Nhom 4/views/admin/manage_users.php">QUẢN LÝ NGƯỜI DÙNG</a></li>
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
                                        <button onclick='showDeleteModal(" . $row['comments_id'] . ")'>Xoá</button>
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

    <!-- Modal xoá bình luận -->
    <div id="deleteModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h3>Xoá bình luận</h3><br>
        <p>Bạn có chắc muốn xoá bình luận này?</p><br>
        <form method="GET" action="manage_comments.php">
            <input type="hidden" name="delete" id="delete_comment_id">
            <button type="button" onclick="closeDeleteModal()">Hủy</button>
            <button type="submit">Xác nhận</button>
        </form>
    </div>

    <!-- Overlay -->
    <div id="overlay" onclick="closeDeleteModal();" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
</body>

</html>

<?php $conn->close(); ?>