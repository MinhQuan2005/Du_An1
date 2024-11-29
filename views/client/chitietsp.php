<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
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
            <p class='price'><?=$productOne['price']?>đ</p>
            <p class="description">
            <?= $productOne['description']?>

            </p>
            <p class="views">Lượt xem: <?= $productOne['views']?></p>
            <div class="size-selection">
                <p>Lựa chọn size:</p>
                <button>35</button>
                <button>36</button>
                <button>37</button>
                <button>38</button>
                <button>39</button>
                <button>40</button>
                <button>41</button>
                <button>42</button>
            </div>
            <div class="actions">
                <!-- <button class="add-to-cart">Thêm vào giỏ hàng</button> -->
            <form action="index.php?act=addToCart" method="POST">
               <input type="hidden" name="product_id" value="<?=$productOne['products_id']; ?>">
              <input type="hidden" name="quantity" value="1"> <!-- Thêm số lượng nếu cần -->
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
