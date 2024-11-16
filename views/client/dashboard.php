<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANG CHỦ</title>
    <link rel="stylesheet" href="css/client/dashboard.css">
</head>
<body>
    <div id="main">
        <header id="header">
            <div class="top-header">

                <div class="logo">
                    NIKE
                </div>

                <div class="menu">
                    <ul>
                        <li><a href="#">MỚI & NỔI BẬT</a></li>
                        <li><a href="#">NAM</a></li>
                        <li><a href="#">NỮ</a></li>
                        <li><a href="#">TRẺ EM</a></li>
                    </ul>
                </div>

                <div class="search">
                    <form>
                        <input type="text" placeholder="Nhập thông tin..." required>
                        <button>Tìm kiếm</button>
                    </form>
                </div>

                <div class="account">
                    <?php if(isset( $_SESSION['user']['username'])) : ?>
                        <span>Chào,<?php echo $_SESSION['user']['username']; ?></span>
                        <a href="index.php?act=logout">Đăng xuất</a>
                    <?php else : ?>
                        <a href="account/login.php">Đăng nhập</a>
                       
                    <?php endif; ?>
                </div>
            </div>

            <div class="banner">
                BANNER
            </div>
        </header>

        <div id="content">
            <h1>MỚI & NỔI BẬT</h1>
            <h1>NAM</h1>
            <h1>NỮ</h1>
            <h1>TRẺ EM</h1>
        </div>

        <footer id="footer">
            <div class="left-section">
                    <p><b>Địa chỉ: </b>FPT Polytechnic Hà Nội</p>
                    <p><b>Hotline: </b>+212244314</p>
                    <p><b>Email: </b>contact@nhom4.com</p>
            </div>

            <div class="right-section">
                <p>Copyright <b>&copy;</b> Dự án 1 by Nhóm 4</p>
                <br>
                <p><b>Chính sách bảo mật | Điều khoản sử dụng</b></p>
            </div>
        </footer>
    </div>
</body>
</html>