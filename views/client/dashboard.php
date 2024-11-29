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
                    <img src="./uploads/logo.png" alt="">
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="index.php?act=home">TRANG CHỦ</a></li>
                        <li><a href="">MỚI & NỔI BẬT</a></li>
                        <li><a href="">NAM</a></li>
                        <li><a href="">NỮ</a></li>
                        <li><a href="">TRẺ EM</a></li>
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
        <div id="content">
            <section class="product-section">
            <h2 id="top">Sản phẩm nổi bật</h2>
            <div class="product-list">
                <?php foreach ($popularProducts as $product) : ?>
                    <div class="product-card">
                        <img src="./uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" >
                        <p><a href="../../../Du an 1_Nhom 4/index.php?act=detailpro&id=<?= $product['products_id'] ?>"><?= $product['name'] ?></a></p>
                        <p><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="product-section">
            <h2 id="nam">Nam</h2>
            <div class="product-list">
                <?php foreach ($menProducts as  $product) : ?>
                    <div class="product-card">
                        <img src="./uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <p><a href="../../../Du an 1_Nhom 4/index.php?act=detailpro&id=<?= $product['products_id'] ?>"><?= $product['name'] ?></a></p>
                        <p><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="product-section">
            <h2 id="nu">Nữ</h2>
            <div class="product-list">
                <?php foreach ($womenProducts as $product) : ?>
                    <div class="product-card">
                        <img src="./uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <p><a href="../../../Du an 1_Nhom 4/index.php?act=detailpro&id=<?= $product['products_id'] ?>"><?= $product['name'] ?></a></p>
                        <p><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="product-section">
            <h2 id="tre em">Trẻ em</h2>
            <div class="product-list">
                <?php foreach ( $kidsProducts as $product) : ?>
                    <div class="product-card">
                        <img src="./uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <p><a href="../../../Du an 1_Nhom 4/index.php?act=detailpro&id=<?= $product['products_id'] ?>"><?= $product['name'] ?></a></p>
                        <p><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
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
