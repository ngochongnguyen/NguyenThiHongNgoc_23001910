<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

// Hàm trả về JSON
function response($success, $message, $data = null, $status = 200) {
    http_response_code($status);

    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

// Đọc dữ liệu JSON
function getJsonInput() {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!is_array($input)) {
        response(false, "Dữ liệu JSON không hợp lệ", null, 400);
    }

    return $input;
}

// Kiểm tra dữ liệu sản phẩm
function validateProduct($data) {
    $name = trim($data["name"] ?? "");
    $price = $data["price"] ?? null;
    $stock = $data["stock"] ?? null;

    if ($name === "" || mb_strlen($name, "UTF-8") > 100) {
        response(false, "Tên sản phẩm không hợp lệ", null, 400);
    }

    if (
        !is_numeric($price) ||
        !is_numeric($stock) ||
        !is_finite((float)$price) ||
        !is_finite((float)$stock) ||
        (float)$price <= 0 ||
        (float)$stock < 0 ||
        floor((float)$price) != (float)$price ||
        floor((float)$stock) != (float)$stock
    ) {
        response(false, "Giá hoặc số lượng không hợp lệ", null, 400);
    }

    return [
        "name" => $name,
        "price" => (int)$price,
        "stock" => (int)$stock
    ];
}

$method = $_SERVER["REQUEST_METHOD"];

// GET: Lấy danh sách sản phẩm
if ($method === "GET") {
    $sql = "SELECT id, name, price, stock, image
            FROM products
            ORDER BY id DESC";

    $result = $conn->query($sql);

    if (!$result) {
        response(false, "Không thể lấy danh sách sản phẩm", null, 500);
    }

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    response(true, "Lấy danh sách thành công", $products);
}

// POST: Thêm sản phẩm
if ($method === "POST") {
    $data = validateProduct(getJsonInput());

    $stmt = $conn->prepare(
        "INSERT INTO products (name, price, stock)
         VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        response(false, "Không thể chuẩn bị câu lệnh SQL", null, 500);
    }

    $stmt->bind_param(
        "sii",
        $data["name"],
        $data["price"],
        $data["stock"]
    );

    if (!$stmt->execute()) {
        response(false, "Thêm sản phẩm thất bại", null, 500);
    }

    $newId = $conn->insert_id;

    response(true, "Thêm sản phẩm thành công", [
        "id" => $newId
    ], 201);
}

// PUT: Sửa sản phẩm
if ($method === "PUT") {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if (!$id || $id <= 0) {
        response(false, "ID sản phẩm không hợp lệ", null, 400);
    }

    $data = validateProduct(getJsonInput());

    $stmt = $conn->prepare(
        "UPDATE products
         SET name = ?, price = ?, stock = ?
         WHERE id = ?"
    );

    if (!$stmt) {
        response(false, "Không thể chuẩn bị câu lệnh SQL", null, 500);
    }

    $stmt->bind_param(
        "siii",
        $data["name"],
        $data["price"],
        $data["stock"],
        $id
    );

    if (!$stmt->execute()) {
        response(false, "Cập nhật sản phẩm thất bại", null, 500);
    }

    if ($stmt->affected_rows === 0) {
        $check = $conn->prepare("SELECT id FROM products WHERE id = ?");
        $check->bind_param("i", $id);
        $check->execute();

        if ($check->get_result()->num_rows === 0) {
            response(false, "Không tìm thấy sản phẩm", null, 404);
        }
    }

    response(true, "Cập nhật sản phẩm thành công");
}

// DELETE: Xóa sản phẩm
if ($method === "DELETE") {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if (!$id || $id <= 0) {
        response(false, "ID sản phẩm không hợp lệ", null, 400);
    }

    $stmt = $conn->prepare(
        "DELETE FROM products WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        response(false, "Xóa sản phẩm thất bại", null, 500);
    }

    if ($stmt->affected_rows === 0) {
        response(false, "Không tìm thấy sản phẩm", null, 404);
    }

    response(true, "Xóa sản phẩm thành công");
}

// Phương thức không được hỗ trợ
header("Allow: GET, POST, PUT, DELETE");
response(false, "Phương thức không được hỗ trợ", null, 405);
