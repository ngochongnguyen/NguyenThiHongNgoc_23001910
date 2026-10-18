<?php
require_once __DIR__ . "/common/auth.php";
require_once __DIR__ . "/model/product.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("ID sản phẩm không hợp lệ.");
}

$product = getProductById($id);

if (!$product) {
    die("Không tìm thấy sản phẩm.");
}

$pageTitle = "Xóa sản phẩm";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    deleteProduct($id);

    header("Location: /shopping_cart/product_list.php");
    exit;
}

require_once __DIR__ . "/view/header.php";
?>

<h1>Xóa sản phẩm</h1>

<p>
    Em có chắc chắn muốn xóa sản phẩm
    <strong><?= htmlspecialchars($product["name"], ENT_QUOTES, "UTF-8") ?></strong>
    không?
</p>

<p>
    Giá:
    <?= htmlspecialchars((string)$product["price"], ENT_QUOTES, "UTF-8") ?>
</p>

<p>
    Số lượng:
    <?= (int)$product["quantity"] ?>
</p>

<form method="POST" action="/shopping_cart/product_delete.php?id=<?= (int)$id ?>">
    <button type="submit">Xác nhận xóa</button>
    <a href="/shopping_cart/product_list.php">Hủy</a>
</form>

<?php require_once __DIR__ . "/view/footer.php"; ?>
