
<?php
require_once __DIR__ . '/model/product.php';

$products = getAllProducts();

require_once __DIR__ . '/view/header.php';
?>

<h2>Danh sách sản phẩm</h2>

<p>
    <a href="product_add.php">Thêm sản phẩm mới</a>
</p>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thao tác</th>
    </tr>

    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['id']) ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</td>
            <td><?= htmlspecialchars($product['quantity']) ?></td>
            <td>
                <a href="product_edit.php?id=<?= $product['id'] ?>">Sửa</a>
                |
                <a href="product_delete.php?id=<?= $product['id'] ?>"
                   onclick="return confirm('Em có chắc muốn xóa sản phẩm này không?')">
                    Xóa
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/view/footer.php'; ?>
