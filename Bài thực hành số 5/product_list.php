<?php
require_once __DIR__ . "/common/auth.php";
require_once __DIR__ . "/model/product.php";

$products = getAllProducts();
$pageTitle = "Danh sách sản phẩm";

require_once __DIR__ . "/view/header.php";
?>

<h1>Danh sách sản phẩm</h1>

<p>
    Xin chào,
    <strong><?= htmlspecialchars($_SESSION["username"] ?? "bạn", ENT_QUOTES, "UTF-8") ?></strong>!
    <a href="/shopping_cart/logout.php">Đăng xuất</a>
</p>

<p>
    <a href="/shopping_cart/product_add.php">+ Thêm sản phẩm mới</a>
</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($products)): ?>
            <tr>
                <td colspan="5">Chưa có sản phẩm nào.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= (int)$product["id"] ?></td>

                    <td>
                        <?= htmlspecialchars($product["name"], ENT_QUOTES, "UTF-8") ?>
                    </td>

                    <td>
                        <?= htmlspecialchars((string)$product["price"], ENT_QUOTES, "UTF-8") ?>
                    </td>

                    <td><?= (int)$product["quantity"] ?></td>

                    <td>
                        <a href="/shopping_cart/product_edit.php?id=<?= (int)$product["id"] ?>">
                            Sửa
                        </a>

                        |

                        <a href="/shopping_cart/product_delete.php?id=<?= (int)$product["id"] ?>">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . "/view/footer.php"; ?>
