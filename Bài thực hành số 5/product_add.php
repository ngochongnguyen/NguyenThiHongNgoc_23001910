<?php
require_once __DIR__ . "/common/auth.php";
require_once __DIR__ . "/model/product.php";

$error = "";
$pageTitle = "Thêm sản phẩm";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $price = $_POST["price"] ?? "";
    $quantity = $_POST["quantity"] ?? "";

    if ($name === "") {
        $error = "Vui lòng nhập tên sản phẩm.";
    } elseif (!is_numeric($price) || (float)$price <= 0) {
        $error = "Giá sản phẩm phải lớn hơn 0.";
    } elseif (
        filter_var($quantity, FILTER_VALIDATE_INT) === false
        || (int)$quantity < 0
    ) {
        $error = "Số lượng phải là số nguyên không âm.";
    } else {
        addProduct($name, $price, (int)$quantity);
        header("Location: /shopping_cart/product_list.php");
        exit;
    }
}

require_once __DIR__ . "/view/header.php";
?>

<h1>Thêm sản phẩm mới</h1>

<?php if ($error !== ""): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
    </p>
<?php endif; ?>

<form method="POST" action="/shopping_cart/product_add.php">
    <p>
        <label for="name">Tên sản phẩm:</label><br>
        <input
            type="text"
            id="name"
            name="name"
            value="<?= htmlspecialchars($_POST["name"] ?? "", ENT_QUOTES, "UTF-8") ?>"
            required
        >
    </p>

    <p>
        <label for="price">Giá:</label><br>
        <input
            type="number"
            id="price"
            name="price"
            min="0.01"
            step="0.01"
            value="<?= htmlspecialchars($_POST["price"] ?? "", ENT_QUOTES, "UTF-8") ?>"
            required
        >
    </p>

    <p>
        <label for="quantity">Số lượng:</label><br>
        <input
            type="number"
            id="quantity"
            name="quantity"
            min="0"
            step="1"
            value="<?= htmlspecialchars($_POST["quantity"] ?? "", ENT_QUOTES, "UTF-8") ?>"
            required
        >
    </p>

    <button type="submit">Thêm sản phẩm</button>
    <a href="/shopping_cart/product_list.php">Quay lại danh sách</a>
</form>

<?php require_once __DIR__ . "/view/footer.php"; ?>
