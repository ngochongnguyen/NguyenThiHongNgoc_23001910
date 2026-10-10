<?php
require_once __DIR__ . '/../common/dbConnect.php';

// Lấy danh sách tất cả sản phẩm
function getAllProducts() {
    global $pdo;

    $sql = "SELECT * FROM products";
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

// Lấy một sản phẩm theo ID
function getProductById($id) {
    global $pdo;

    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    return $stmt->fetch();
}

// Thêm sản phẩm
function addProduct($name, $price, $quantity) {
    global $pdo;

    $sql = "INSERT INTO products (name, price, quantity)
            VALUES (:name, :price, :quantity)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ]);
}

// Cập nhật sản phẩm
function updateProduct($id, $name, $price, $quantity) {
    global $pdo;

    $sql = "UPDATE products
            SET name = :name,
                price = :price,
                quantity = :quantity
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ]);
}

// Xóa sản phẩm
function deleteProduct($id) {
    global $pdo;

    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    return $stmt->rowCount() > 0;
}
?>
