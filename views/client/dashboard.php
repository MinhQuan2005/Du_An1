<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANG CHỦ</title>
<<<<<<< HEAD
    <link rel="stylesheet" href="css/client/dashboard.css">
</head>
<body>
    <div id="main">
        <header id="header">
            <div class="top-header">
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
                    <?php if(isset($_SESSION['username'])) : ?>
                        <span>Chào, <?php echo $_SESSION['username']; ?></span>
                        <a href="#">Đăng xuất</a>
                    <?php else : ?>
                        <a href="#">Đăng nhập</a>
                        <a href="#">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="banner">
                <img src="">
            </div>
        </header>
    </div>
=======
</head>
<body>

>>>>>>> 18e0ed203a3abe72b06ed10bd3fd1a6f71646347
</body>
</html>