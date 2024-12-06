<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-5">
        <h1 class="text-center">Thanh toán</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalPrice = 0;
                foreach ($cartItems as $index => $item): 
                    $itemTotalPrice = $item['price'] * $item['quantity'];
                    $totalPrice += $itemTotalPrice; 
                ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> ₫</td>
                        <td><?= number_format($itemTotalPrice, 0, ',', '.') ?> ₫</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Tổng tiền:</strong></td>
                    <td><?= number_format($totalPrice, 0, ',', '.') ?> ₫</td>
                </tr>
            </tfoot>
        </table>
        <form action="index.php?act=processOrder" method="POST">
            <h3>Thông tin nhận hàng</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
                <a href="index.php?act=cart" class="btn btn-secondary">Quay lại giỏ hàng</a>
            </div>
        </form>
    </div>
    <footer id="footer">
            <div class="left-section">
                <p><b>Địa chỉ: </b>FPT Polytechnic Hà Nội</p>
                <p><b>Hotline: </b>+212244314</p>
                <p><b>Email: </b>contact@nhom4.com</p>
            </div>
            <div class="right-section">
                <p>Copyright <b>&copy;</b> Dự án 1 by Nhóm 4</p> <br>
                <p><b>Chính sách bảo mật | Điều khoản sử dụng</b></p>
            </div>
        </footer>
        </div>
    
</body>
<style>
   .mt-5{
    background-color: white;
    color: black; 
    padding: 20px;
    border-radius: 8px; 
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
    margin-bottom:20px;
   }
</style>
</html>