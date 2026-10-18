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

$error = "";
$pageTitle = "Sửa sản phẩm";

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
        updateProduct($id, $name, $price, (int)$quantity);

        header("Location: /shopping_cart/product_list.php");
        exit;
    }
}

require_once __DIR__ . "/view/header.php";
?>

<h1>Sửa sản phẩm</h1>

<?php if ($error !== ""): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
    </p>
<?php endif; ?>

<form method="POST" action="/shopping_cart/product_edit.php?id=<?= (int)$id ?>">
    <p>
        <label for="name">Tên sản phẩm:</label><br>
        <input
            type="text"
            id="name"
            name="name"
            value="<?= htmlspecialchars($_POST["name"] ?? $product["name"], ENT_QUOTES, "UTF-8") ?>"
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
            value="<?= htmlspecialchars((string)($_POST["price"] ?? $product["price"]), ENT_QUOTES, "UTF-8") ?>"
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
            value="<?= htmlspecialchars((string)($_POST["quantity"] ?? $product["quantity"]), ENT_QUOTES, "UTF-8") ?>"
            required
        >
    </p>

    <button type="submit">Lưu thay đổi</button>
    <a href="/shopping_cart/product_list.php">Quay lại danh sách sản phẩm</a>
</form>

<?php require_once __DIR__ . "/view/footer.php"; ?>
