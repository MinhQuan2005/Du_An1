<!-- views/cart/view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Giỏ hàng của bạn</h1>
        <form action="index.php?act=updateCart" method="POST">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Sản phẩm</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Giá</th>
                <th scope="col">Tổng</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><img src="<?= $item['image'] ?>" class="img-thumbnail" alt="Product Image"></td>
                <td>
                    <input type="number" name="quantity[<?= $item['products_id'] ?>]" value="<?= $item['quantity'] ?>" min="1">
                </td>
                <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</td>
                <td>
                    <a href="index.php?act=deleteFromCart&id=<?= $item['products_id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Thanh toán</button>
</form>
    </div>
</body>
</html>
