<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANG CHỦ</title>
    <link rel="stylesheet" href="./css/client/dashboard.css">
</head>

<body>

    <div id="main">
        <header id="header">
            <div class="top-header">
                <div class="logo">
                    <a href="index.php?act=home">
                        <img src="./uploads/logo.png">
                    </a>
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="#top">MỚI & NỔI BẬT</a></li>
                        <li><a href="index.php?act=dmnam">NAM</a></li>
                        <li><a href="index.php?act=dmnu">NỮ</a></li>
                        <li><a href="index.php?act=dmtreem">TRẺ EM</a></li>
                    </ul>
                </div>
                <div class="search">
                              <form action="index.php" method="GET">
    <input type="hidden" name="act" value="search"> <!-- Giữ tham số act -->
    <input type="text" name="query" placeholder="Nhập thông tin..." required>
    <button type="submit">Tìm kiếm</button>
</form>

                </div>
                <div class="account">
                <?php if(isset($_SESSION['user']['username'])) : ?>
                        <button class="butt" type="submit"><a href="index.php?act=cart">🛒</a></button>
                        <a style="background-color: #141414;
    color: white; padding: .8rem; border-radius: .3rem;" class="butt" href="index.php?act=orderHistory">Đơn hàng</a>
                        <form action="index.php?act=logout" method="POST">
                            <button type="submit">Đăng xuất</button>
                        </form>
                    <?php else : ?>
                        <button class="butt" type="submit"><a href="index.php?act=cart">🛒</a></button>
                        <a href="account/login.php"><button>Đăng nhập</button></a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
       
    </div>

    <h1>Lịch Sử Đơn Hàng</h1>
    <table id="orderTable">
        <thead>
            <tr>
                <th>ID Đơn Hàng</th>
                <th>Tên</th>
                <th>Điện Thoại</th>
                <th>Email</th>
                <th>Địa Chỉ</th>
                <th>Ngày Đặt</th>
                <th>Trạng Thái</th>
                <th>Trạng Thái Thanh Toán</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $order['orders_id']; ?></td>
            <td><?php echo $order['name']; ?></td>
            <td><?php echo $order['phone']; ?></td>
            <td><?php echo $order['email']; ?></td>
            <td><?php echo $order['address']; ?></td>
            <td><?php echo $order['order_date']; ?></td>
            <td><?php echo $order['status']; ?></td>
            <td><?php echo $order['payment_status']; ?></td>
            <td>
                <?php if ($order['status'] !== 'Đã huỷ' &&  $order['payment_status'] !== 'Thanh toán thành công') : ?>
                    <form action="index.php?act=cancelOrder" method="POST">
                        <input type="hidden" name="orderId" value="<?php echo $order['orders_id']; ?>">
                        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">Hủy</button>
                    </form>
                <?php else : ?>
                     
                <?php endif; ?>
            </td>
            <style>
                tbody button[type="submit"] {
    background-color: #f44336; /* Màu đỏ */
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

tbody button[type="submit"]:hover {
    background-color: #d32f2f; /* Màu đỏ đậm hơn khi hover */
}

tbody button[type="submit"]:focus {
    outline: none;
    box-shadow: 0 0 4px #d32f2f;
}

            </style>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    <div class="pagination" id="pagination">
        <button id="prevBtn" class="disabled" disabled>Trang Trước</button>
        <button id="nextBtn">Trang Sau</button>
    </div>

    <script>
        const rowsPerPage = 10;
        const rows = document.querySelectorAll("#orderTable tbody tr");
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        let currentPage = 1;

        function displayPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? "" : "none";
            });

            document.getElementById("prevBtn").classList.toggle("disabled", page === 1);
            document.getElementById("nextBtn").classList.toggle("disabled", page === totalPages);
            document.getElementById("prevBtn").disabled = page === 1;
            document.getElementById("nextBtn").disabled = page === totalPages;
        }

        document.getElementById("prevBtn").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                displayPage(currentPage);
            }
        });

        document.getElementById("nextBtn").addEventListener("click", () => {
            if (currentPage < totalPages) {
                currentPage++;
                displayPage(currentPage);
            }
        });

        displayPage(currentPage); // Hiển thị trang đầu tiên
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination button {
            margin: 0 5px;
            padding: 10px 15px;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            th, td {
                padding: 10px;
                font-size: 14px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>

    <footer id="footer">
        <div class="left-section">
            <p><b>Địa chỉ: </b>FPT Polytechnic Hà Nội</p>
            <p><b>Hotline: </b>+212244314</p>
            <p><b>Email: </b>contact@nhom4.com</p>
        </div>
        <div class="right-section">
            <p>Copyright <b>&copy;</b> Dự án 1 by Nhóm 4</p>
            <br>
            <p><b>Chính sách bảo mật | Điều khoản sử dụng</b></p>
        </div>
    </footer>

</body>
</html>
