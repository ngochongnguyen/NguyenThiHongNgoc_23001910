<?php
require_once __DIR__ . '/model/product.php';

$error = '';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit('ID sản phẩm không hợp lệ.');
}

$product = getProductById($id);

if (!$product) {
    exit('Không tìm thấy sản phẩm.');
}

$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    if ($name === '') {
        $error = 'Vui lòng nhập tên sản phẩm.';
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = 'Giá sản phẩm phải lớn hơn 0.';
    } elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false || $quantity < 0) {
        $error = 'Số lượng phải là số nguyên không âm.';
    } else {
        updateProduct($id, $name, $price, $quantity);
        header('Location: product_list.php');
        exit;
    }
}

require_once __DIR__ . '/view/header.php';
?>

<h2>Sửa sản phẩm</h2>

<?php if ($error !== ''): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST" action="">
    <p>
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name"
               value="<?= htmlspecialchars($name) ?>" required>
    </p>

    <p>
        <label>Giá sản phẩm (VNĐ):</label><br>
        <input type="number" name="price" min="0.01" step="0.01"
               value="<?= htmlspecialchars((string)$price) ?>" required>
    </p>

    <p>
        <label>Số lượng:</label><br>
        <input type="number" name="quantity" min="0" step="1"
               value="<?= htmlspecialchars((string)$quantity) ?>" required>
    </p>

    <button type="submit">Lưu thay đổi</button>
    <a href="product_list.php">Quay lại</a>
</form>

<?php require_once __DIR__ . '/view/footer.php'; ?>