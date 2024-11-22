<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" href="../../../Du an 1_Nhom 4/css/client/spct.css">
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
                        <span>Chào, <?php echo $_SESSION['user']['username']; ?></span>
                        <form action="../../../Du an 1_Nhom 4/index.php?act=logout" method="POST">
                            <button type="submit">Đăng xuất</button>
                        </form>
                    <?php else : ?>
                        <a href="account/login.php"><button>Đăng nhập</button></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- <div class="banner-container">
                <div class="slides">
                    <div class="slide" style="background-image: url('../../../Du an 1_Nhom 4/uploads/banner1.jpg')"></div>
                    <div class="slide" style="background-image: url('../../../Du an 1_Nhom 4/uploads/banner2.jpg')"></div>
                    <div class="slide" style="background-image: url('../../../Du an 1_Nhom 4/uploads/banner3.jpg')"></div>
                </div>
                <button class="nav-button left" onclick="prevSlide()">&#10094;</button>
                <button class="nav-button right" onclick="nextSlide()">&#10095;</button>
                <div class="dots">
                    <div class="dot active" onclick="currentSlide(0)"></div>
                    <div class="dot" onclick="currentSlide(1)"></div>
                    <div class="dot" onclick="currentSlide(2)"></div>
                </div>
            </div> -->
        </header>
    <div class="product-detail-container">
        <div class="product-image">
            <img src="../../../Du an 1_Nhom 4/uploads/<?=$productOne['image']?>" alt="Sản phẩm">
        </div>
        <div class="product-info">
            <h1><?= $productOne['name']  ?></h1>
            <p class='price'><?= $productOne['price']  ?></p>
            <p class="description">
            <?= $productOne['description']?>

            </p>
            <p>Lượt xem:<?= $productOne['views']?></p>
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
                <button class="add-to-cart">Thêm vào giỏ hàng</button>
                <button class="buy-now">Mua ngay</button>
            </div>
        </div>
    </div>
    <div class="comments-section">
        <h2>Bình luận</h2>
        <?php if (isset($_SESSION['user']['username'])): ?>
            <div class="comment-list">
                <div class="comment">
                    <p><strong>vuiqua:</strong> Sản phẩm rất tuyệt, đáng mua và trải nghiệm.</p>
                </div>
                <div class="comment">
                    <p><strong>vuilam:</strong> Dù ở xa nhưng giao rất nhanh, chăm sóc khách hàng tốt, tư vấn nhiệt tình.</p>
                </div>
            </div>
            <form class="comment-form" method="POST" action="index.php?act=comment">
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
</html>
