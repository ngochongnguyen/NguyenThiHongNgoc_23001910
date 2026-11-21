<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

function response($success, $data = null, $message = null, $status = 200, $pagination = null)
{
    http_response_code($status);

    $result = [
        "success" => $success
    ];

    if ($success) {
        $result["data"] = $data;

        if ($pagination !== null) {
            $result["pagination"] = $pagination;
        }
    } else {
        $result["message"] = $message;
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

function getInput()
{
    $data = json_decode(file_get_contents("php://input"), true);

    if (!is_array($data)) {
        response(false, null, "Dữ liệu JSON không hợp lệ", 400);
    }

    return $data;
}

function validateProduct($data)
{
    $name = trim($data["name"] ?? "");

    if (
        $name === "" ||
        !is_string($data["name"]) ||
        mb_strlen($name) > 100
    ) {
        response(false, null, "Tên sản phẩm không hợp lệ", 400);
    }

    $price = $data["price"] ?? null;
    $stock = $data["stock"] ?? null;

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
        response(false, null, "Giá hoặc số lượng không hợp lệ", 400);
    }

    return [
        "name" => $name,
        "price" => (int)$price,
        "stock" => (int)$stock
    ];
}

$method = $_SERVER["REQUEST_METHOD"];

try {

    switch ($method) {

        // GET: Phân trang danh sách sản phẩm
        case "GET":

            $page = 1;
            $limit = 5;

            if (isset($_GET["page"])) {
                if (
                    !is_string($_GET["page"]) ||
                    !ctype_digit($_GET["page"]) ||
                    (int)$_GET["page"] <= 0
                ) {
                    response(false, null, "Page phải là số nguyên dương", 400);
                }

                $page = (int)$_GET["page"];
            }

            if (isset($_GET["limit"])) {
                if (
                    !is_string($_GET["limit"]) ||
                    !ctype_digit($_GET["limit"]) ||
                    (int)$_GET["limit"] !== 5
                ) {
                    response(false, null, "Limit phải bằng 5", 400);
                }
            }

            // Đếm tổng sản phẩm
            $countStmt = $conn->query(
                "SELECT COUNT(*) FROM products"
            );

            $total = (int)$countStmt->fetchColumn();

            // Tính tổng trang
            $totalPages = max(1, (int)ceil($total / $limit));

            // Điều chỉnh page nếu vượt quá trang cuối
            $page = min($page, $totalPages);

            $offset = ($page - 1) * $limit;

            // Lấy sản phẩm theo trang
            $sql = "SELECT id, name, price, stock, image
                    FROM products
                    ORDER BY id DESC
                    LIMIT :limit OFFSET :offset";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

            $stmt->execute();

            $products = $stmt->fetchAll();

            $pagination = [
                "page" => $page,
                "limit" => $limit,
                "total" => $total,
                "total_pages" => $totalPages
            ];

            response(true, $products, null, 200, $pagination);

            break;

        // POST: Thêm sản phẩm
        case "POST":

            $data = validateProduct(getInput());

            $sql = "INSERT INTO products (name, price, stock)
                    VALUES (:name, :price, :stock)";

            $stmt = $conn->prepare($sql);
            $stmt->execute($data);

            response(true, [
                "id" => $conn->lastInsertId()
            ], "Thêm sản phẩm thành công", 201);

            break;

        // PUT: Sửa sản phẩm
        case "PUT":

            if (
                !isset($_GET["id"]) ||
                !ctype_digit($_GET["id"]) ||
                (int)$_GET["id"] <= 0
            ) {
                response(false, null, "ID không hợp lệ", 400);
            }

            $id = (int)$_GET["id"];
            $data = validateProduct(getInput());

            $check = $conn->prepare(
                "SELECT id FROM products WHERE id = :id"
            );

            $check->execute(["id" => $id]);

            if (!$check->fetch()) {
                response(false, null, "Sản phẩm không tồn tại", 404);
            }

            $data["id"] = $id;

            $sql = "UPDATE products
                    SET name = :name, price = :price, stock = :stock
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute($data);

            response(true, null, "Cập nhật sản phẩm thành công");

            break;

        // DELETE: Xóa sản phẩm
        case "DELETE":

            if (
                !isset($_GET["id"]) ||
                !ctype_digit($_GET["id"]) ||
                (int)$_GET["id"] <= 0
            ) {
                response(false, null, "ID không hợp lệ", 400);
            }

            $id = (int)$_GET["id"];

            $stmt = $conn->prepare(
                "DELETE FROM products WHERE id = :id"
            );

            $stmt->execute(["id" => $id]);

            if ($stmt->rowCount() === 0) {
                response(false, null, "Sản phẩm không tồn tại", 404);
            }

            response(true, null, "Xóa sản phẩm thành công");

            break;

        default:
            response(false, null, "Phương thức không được hỗ trợ", 405);
    }

} catch (PDOException $e) {

    response(false, null, "Lỗi truy vấn cơ sở dữ liệu", 500);
}

?>
