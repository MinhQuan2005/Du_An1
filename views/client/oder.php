<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="../../../Du an 1_Nhom 4/css/client/dashboard.css">
</head>
<body>
<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    <header id="header">
        <div class="top-header">
            <div class="logo">
                <img src="./uploads/logo.png" alt="Logo">
            </div>
            <div class="menu">
                <ul>
                    <li><a href="../../../Du an 1_Nhom 4/index.php?act=home">TRANG CHỦ</a></li>
                    <li><a href="#top">MỚI & NỔI BẬT</a></li>
                    <li><a href="#nam">NAM</a></li>
                    <li><a href="#nu">NỮ</a></li>
                    <li><a href="#tre em">TRẺ EM</a></li>
                </ul>
            </div>
            <div class="search">
                <form>
                    <input type="text" placeholder="Nhập thông tin..." required>
                    <button>Tìm kiếm</button>
                </form>
            </div>
            <div class="account">
                <?php if (isset($_SESSION['user']['username'])) : ?>
                    <button class="butt" type="submit"><a href="index.php?act=cart">🛒</a></button>
                    <form action="index.php?act=logout" method="POST">
                        <button type="submit">Đăng xuất</button>
                    </form>
                <?php else : ?>
                    <button class="butt" type="submit"><a href="index.php?act=">🛒</a></button>
                    <a href="../../../Du an 1_Nhom 4/account/login.php">
                        <button>Đăng nhập</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <form class="formorder" action="index.php?act=placeOrder" method="POST">
        <h4>Thông tin người nhận</h4>
        <label>Họ Tên:</label>
        <input type="text" name="name" value="<?= $userInfo['name'] ?>" required><br>
        <label>Số điện thoại:</label>
        <input type="text" name="phone" value="<?= $userInfo['phone'] ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= $userInfo['email'] ?>" required><br>
        <label>Địa chỉ:</label>
        <input type="text" name="address" value="<?= $userInfo['address'] ?>" required><br>

        <h4>Chi tiết giỏ hàng</h4>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartDetails as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td>
                            <img src="./uploads/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                        </td>
                        <td><?= number_format($item['price'], 2) ?> VND</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity'], 2) ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-price">
            <h3>Tạm tính: <span><?= number_format($totalPrice, 2) ?> VND</span></h3>
            <h3>Phí ship: <span><?= number_format(30000, 2) ?> VND</span></h3>
            <h3>Tổng cộng: <span><?= number_format($totalPrice + 30000, 2) ?> VND</span></h3>
        </div>
        <input type="hidden" name="total_price" value="<?= $totalPrice + 30000 ?>">

        <!-- Nút Thanh toán COD -->
        <button class='thanhtoan' type="submit">Thanh toán</button>
    </form>

    <!-- Form Thanh toán VNPay -->
    <div class="payment-buttons">
        <form action="index.php?act=vnpayPayment" method="POST">
             <input type="hidden" name="order_id" value="<?= uniqid() ?>"> 
            <input type="hidden" name="total_price" value="<?= $totalPrice + 30000 ?>">  
            <button type="submit">Thanh toán bằng VNPay</button>
       </form> 


        <!-- Form Thanh toán MoMo -->
        <!-- <form action="index.php?act=momoPayment" method="POST"> -->
            <!-- <input type="hidden" name="order_id" value="<?= uniqid() ?>"> Mã đơn hàng -->
            <!-- <input type="hidden" name="total_price" value="<?= $totalPrice + 30000 ?>"> Tổng tiền -->
            <!-- <button type="submit">Thanh toán bằng MoMo</button> -->
        <!-- </form> -->
    </div> 
    <footer id="footer" class="mt-5">
        <div class="left-section">
            <p><b>Địa chỉ:</b> FPT Polytechnic Hà Nội</p>
            <p><b>Hotline:</b> +212244314</p>
            <p><b>Email:</b> contact@nhom4.com</p>
        </div>
        <div class="right-section">
            <p>Copyright <b>&copy;</b> Dự án 1 by Nhóm 4</p>
            <p><b>Chính sách bảo mật | Điều khoản sử dụng</b></p>
        </div>
    </footer>
</body>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

    .formorder {
            background-color: #fff;
            padding: 20px;
            max-width: 800px;
            margin: 100px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h4{
            color: #181616;
            font-size:20px;
            padding: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        .formorder input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .formorder input[type="submit"],
        .thanhtoan {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        /* .total-price input[type="submit"]:hover,
        button:hover {
            background-color: #0056b3;
        } */

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8f8f8;
            color: #333;
        }

        td img {
            max-width: 100px;
            height: auto;
        }

        .total-price {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin-top: 20px;
    padding: 15px;
    background-color: #f8f8f8;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.total-price h3 {
    margin: 10px 0;
    /* font-size:20px; */
}

.total-price span {
    font-size: 18px;
    color: #e60000; /* Màu đỏ nổi bật cho giá trị */
    font-weight: bold;
}

.total-price .shipping {
    font-size: 18px;
    color: #007bff; /* Màu xanh cho phí ship */
}

.total-price .total {
    font-size: 26px;
    color: #28a745; /* Màu xanh lá cây cho tổng tiền */
    font-weight: bold;
}

.total-price .total span {
    font-size: 28px;
    color: #28a745;
}
</style>
</html>
