<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm Trẻ Em</title>
   <link rel="stylesheet" href="./css/client/dashboard.css">
</head>
<body>
<header id="header">
            <div class="top-header">
                <div class="logo">
                    <img src="./uploads/logo.png" alt="">
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="?act=home">MỚI & NỔI BẬT</a></li>
                        <li><a href="?act=dmnam">NAM</a></li>
                        <li><a href="?act=dmnu">NỮ</a></li>
                        <li><a href="?act=dmtreem">TRẺ EM</a></li>
                        
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
                        <span>Chào, <?php echo $_SESSION['user']['username']; ?></span>
                        <form action="index.php?act=logout" method="POST">
                            <button type="submit">Đăng xuất</button>
                        </form>
                    <?php else : ?>
                        <a href="account/login.php"><button>Đăng nhập</button></a>
                    <?php endif; ?>
                </div>
            </div>
                        
            <div class="banner-container">
                <div class="slides">
                    <div class="slide" style="background-image: url('./uploads/banner1.jpg')"></div>
                    <div class="slide" style="background-image: url('./uploads/banner2.jpg')"></div>
                    <div class="slide" style="background-image: url('./uploads/banner3.jpg')"></div>
                </div>
                <button class="nav-button left" onclick="prevSlide()">&#10094;</button>
                <button class="nav-button right" onclick="nextSlide()">&#10095;</button>
                <div class="dots">
                    <div class="dot active" onclick="currentSlide(0)"></div>
                    <div class="dot" onclick="currentSlide(1)"></div>
                    <div class="dot" onclick="currentSlide(2)"></div>
                </div>
            </div>
        </header>
    <h1>Sản phẩm dành cho Trẻ Em</h1>
    <div class="product-list">
        <?php if (!empty($kidsProducts)): ?>
            <?php foreach ($kidsProducts as $product): ?>
                <div class="product-card">
                    <img src="./uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <p><?php echo htmlspecialchars($product['name']); ?></p>
                    <p><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có sản phẩm nào.</p>
        <?php endif; ?>
    </div>
    <footer id="footer">
            <div class="left-section">
                <p><b>Địa chỉ: </b>FPT Polytechnic Hà Nội</p>
                <p><b>Hotline: </b>+212244314</p>
                <p><b>Email: </b>contact@nhom4.com</p>
            </div>
            <div class="right-section">
                <p>Copyright <b>&copy;</b> Dự án 1 by Nhóm 4</p>
                <p><b>Chính sách bảo mật | Điều khoản sử dụng</b></p>
            </div>
        </footer>
    </div>
</body>
</html>
