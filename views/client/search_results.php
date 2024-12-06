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
        <?php if (!empty($results)): ?>
    <section class="product-section">
        <h2 id="search-results">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($search); ?>"</h2>
        <div class="product-list">
            <?php foreach ($results as $product): ?>
                <div class="product-card">
                    <a href="index.php?act=detailpro&id=<?php echo $product['products_id']; ?>">
                        <img src="./uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <p><?php echo htmlspecialchars($product['name']); ?></p>
                        <p><?php echo number_format($product['price'], 0, ',', '.') ?> ₫</p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php else: ?>
    <h2>Không tìm thấy sản phẩm nào cho: "<?php echo htmlspecialchars($search); ?>"</h2>
<?php endif; ?>

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
    <script>
        let currentIndex = 0;
        const slides = document.querySelector('.slides');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = dots.length;
        let slideInterval;

        function updateSlidePosition() {
            slides.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach(dot => dot.classList.remove('active'));
            dots[currentIndex].classList.add('active');
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlidePosition();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlidePosition();
        }

        function currentSlide(index) {
            currentIndex = index;
            updateSlidePosition();
        }

        function startAutoSlide() {
            slideInterval = setInterval(nextSlide, 2000); 
        }

        function stopAutoSlide() {
            clearInterval(slideInterval);
        }
        startAutoSlide();

        
        const bannerContainer = document.querySelector('.banner-container');
        bannerContainer.addEventListener('mouseenter', stopAutoSlide);
        bannerContainer.addEventListener('mouseleave', startAutoSlide);

    </script>
</body>
<style>
    .product-card a {
        display: block;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        margin-top: 8px;
        transition: color 0.3s ease;
    }

    .product-card a:hover {
        color: #ff6600;
        text-decoration: none;
    }
</style>
</html>