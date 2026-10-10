<?php
require_once __DIR__ . '/model/product.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit('ID sản phẩm không hợp lệ.');
}

$product = getProductById($id);

if (!$product) {
    exit('Không tìm thấy sản phẩm.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirmId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($confirmId !== $id) {
        exit('Yêu cầu xóa không hợp lệ.');
    }

    deleteProduct($id);

    header('Location: product_list.php');
    exit;
}

require_once __DIR__ . '/view/header.php';
?>

<h2>Xóa sản phẩm</h2>

<p>Em có chắc chắn muốn xóa sản phẩm này không?</p>

<ul>
    <li>
        <strong>Tên:</strong>
        <?= htmlspecialchars($product['name']) ?>
    </li>
    <li>
        <strong>Giá:</strong>
        <?= number_format((float)$product['price'], 0, ',', '.') ?> VNĐ
    </li>
    <li>
        <strong>Số lượng:</strong>
        <?= htmlspecialchars((string)$product['quantity']) ?>
    </li>
</ul>

<form method="POST" action="">
    <input type="hidden" name="id" value="<?= (int)$id ?>">
    <button type="submit">Xác nhận xóa</button>
    <a href="product_list.php">Hủy</a>
</form>

<?php require_once __DIR__ . '/view/footer.php'; ?>