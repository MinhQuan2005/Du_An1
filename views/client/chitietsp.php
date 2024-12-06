<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHI TIẾT SẢN PHẨM</title>
    <link rel="stylesheet" href="../../../Du an 1_Nhom 4/css/client/sanphamct.css">
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
                    <a href="index.php?act=home">
                        <img src="./uploads/logo.png">
                    </a>
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="index.php?act=home">MỚI & NỔI BẬT</a></li>
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
    <div class="product-detail-container">
        <div class="product-image">
            <img src="../../../Du an 1_Nhom 4/uploads/<?=$productOne['image']?>" alt="Sản phẩm">
        </div>
        <div class="product-info">
            <h1><?= $productOne['name']  ?></h1>
            <p class='price'><?= number_format($productOne['price'], 0, ',', '.') ?> ₫</p>
            <p class="description">
            <b>Mô tả:   </b><br> 
            <?= $productOne['description']?>
            </p>

            <p class="views">Lượt xem: <?= $productOne['views']?></p> <br><br><br><br>

            <div class="actions">
            <form action="index.php?act=addToCart" method="POST">
               <input type="hidden" name="product_id" value="<?=$productOne['products_id']; ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="add-to-cart">Thêm vào giỏ hàng</button>
              <button type="submit" class="buy-now">Mua ngay</button>
            </form>
            </div>
        </div>
    </div>
    <div class="comments-section">
        <h2>Bình luận</h2>
        <?php if (isset($_SESSION['user']['username'])): ?>
        <div class="comment-list">
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> 
                    <?php echo htmlspecialchars($comment['comment']); ?> 
                    <span class="comment-time"><?php echo date('d/m/Y H:i',strtotime($comment['created_at'])); ?></span></p>
                </div>
            <?php endforeach; ?>
        </div>

        <form class="comment-form" method="POST" action="index.php?act=addComment&id=<?= $productOne['products_id']; ?>">
            <input type="text" placeholder="Viết bình luận..." name="comment" required>
            <button type="submit">Gửi</button>
        </form>
        <?php else : ?>
            <p>Vui lòng <a href="../../../Du an 1_Nhom 4/account/login.php">đăng nhập</a> để xem và gửi bình luận.</p>
        <?php endif; ?>
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
</html>
