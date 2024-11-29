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
                        <li><a href="#top">MỚI & NỔI BẬT</a></li>
                        <li><a href="?act=dmnam">NAM</a></li>
                        <li><a href="?act=dmnu">NỮ</a></li>
                        <li><a href="?act=dmtreem">TRẺ EM</a></li>
                    </ul>
                </div>
                <div class="search">
                <div>
                    <form class="d-flex" role="search" method="get" id="searchForm">
                        <input type="text" name="search" id="searchInput" placeholder="Tìm kiếm..." autocomplete="off" class="form-control me-2 flex-grow-1">
                        <button type="submit">Tìm kiếm</button>
                    </form>
                    
                </div>
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
    <!-- Hiển thị các sản phẩm tìm thấy -->
    <?php if ($popularProducts): ?>
        <?php foreach ($popularProducts as $product) : ?>
            <div class="product-card">
                <img src="./uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" />
                <p><?= htmlspecialchars($product['name']) ?></p>
                <p><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                <?php foreach ($popularProducts as $product) : ?>
                    <div class="product-card">
                        <img src="./uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" >
                        <p><a href="../../../Du an 1_Nhom 4/index.php?act=detailpro&id=<?= $product['products_id'] ?>"><?= $product['name'] ?></a></p>
                        <p><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Nếu không tìm thấy sản phẩm nào -->
        <p>No products found.</p>
    <?php endif; ?>
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
    // search
    <script>
    // Get the input and form elements
    const searchInput = document.getElementById('searchInput');

    // Check for 'search' parameter in the URL on page load
    window.addEventListener('load', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search');

        // If there's a search query, set it in the input field
        if (searchQuery) {
            searchInput.value = searchQuery;
            // Load the search results, e.g., searchUsers(searchQuery);
        } else {
            // If there's no search query, load the full list
            fetchUserData();  // Call the function that loads the full list
        }
    });

    // Listen for the Enter key press in the input field
    searchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {  // Check if the key pressed is Enter
            event.preventDefault();  // Prevent the default form action (no immediate reload)

            // Get the value from the input field
            const query = searchInput.value.trim();

            // Check if the input field has a value
            if (query) {
                // Update the URL with the search parameter and reload the page
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('search', query);
                window.location.href = currentUrl.href;
            } else {
                // If the input is empty, clear the search parameter and reload the full list
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.delete('search');
                window.location.href = currentUrl.href;  // Reload to show the full list
            }
        }
    });
</script>
</body>
</html>
