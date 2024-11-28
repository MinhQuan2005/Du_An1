<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../Du an 1_Nhom 4/css/client/dashboard.css">

</head>
<body>
<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
    <header id="header">
            <div class="top-header">
                <div class="logo">
                    <img src="./uploads/logo.png" alt="">
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
                <?php if(isset($_SESSION['user']['username'])) : ?>
                        <button class="butt" type="submit"><a href="index.php?act=cart">🛒</a></button>
                        <form action="index.php?act=logout" method="POST">
                            <button type="submit">Đăng xuất</button>
                        </form>
                    <?php else : ?>
                        <button class="butt" type="submit"><a href="index.php?act=">🛒</a></button>
                        <a href="../../../Du an 1_Nhom 4/account/login.php"><button>Đăng nhập</button></a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Giỏ hàng</h1>
        <form method="post" action="index.php?act=updateCart">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
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
                            <td><img src="./uploads/<?= $item['image'] ?>" class="img-fluid" style="width: 100px;"></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                            <td>
                                <input type="number" name="quantity[<?= $item['cart_details_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width: 80px;">
                                <input type="hidden" name="cart_details_id[<?= $item['cart_details_id'] ?>]" value="<?= $item['cart_details_id'] ?>">
                            </td>
                            <td><?= number_format($itemTotalPrice, 0, ',', '.') ?> VND</td> 
                            <td>
                                <a href="index.php?act=deleteFromCart&cart_details_id=<?= $item['cart_details_id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    
                    <tr>
                        <td colspan="5" class="text-end"><strong>Tổng tiền:</strong></td>
                        <td colspan="0"><?= number_format($totalPrice, 0, ',', '.') ?> VND</td>
                        <td> <button type="submit" class="btn btn-success">Cập nhật</button></td>
                    </tr>
                </tfoot>
            </table>
            <div class="d-flex justify-content-between">
                <a href="index.php?act=home" class="btn btn-secondary">Tiếp tục mua sắm</a>
                <a href="#"  class="btn btn-secondary">Thanh toán đơn hàng</a>
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
    .container{
        width: 80%;
        background: #fff;
        padding: 60px 60px;
        
    }
    
</style>
</html>
