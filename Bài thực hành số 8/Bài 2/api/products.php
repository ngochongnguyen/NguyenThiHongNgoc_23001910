<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

// Ham tra ve JSON
function response($success, $data = null, $message = null, $status = 200)
{
    http_response_code($status);

    $result = ["success" => $success];

    if ($success) {
        if ($data !== null) {
            $result["data"] = $data;
        }
    } else {
        $result["message"] = $message;
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

// Doc du lieu JSON
function getInput()
{
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!is_array($data)) {
        response(false, null, "Du lieu JSON khong hop le", 400);
    }

    return $data;
}

// Kiem tra du lieu san pham
function validateProduct($data)
{
    if (
        !isset($data["name"]) ||
        !is_string($data["name"])
    ) {
        response(false, null, "Ten san pham khong hop le", 400);
    }

    $name = trim($data["name"]);

    if (mb_strlen($name) < 1 || mb_strlen($name) > 100) {
        response(false, null, "Ten san pham phai tu 1 den 100 ky tu", 400);
    }

    if (
        !isset($data["price"]) ||
        !is_int($data["price"]) ||
        $data["price"] <= 0
    ) {
        response(false, null, "Gia san pham phai la so nguyen lon hon 0", 400);
    }

    if (
        !isset($data["stock"]) ||
        !is_int($data["stock"]) ||
        $data["stock"] < 0
    ) {
        response(false, null, "So luong ton phai la so nguyen khong am", 400);
    }

    return [
        "name" => $name,
        "price" => $data["price"],
        "stock" => $data["stock"]
    ];
}

try {
    $method = $_SERVER["REQUEST_METHOD"];

    switch ($method) {

        // GET: Lay danh sach san pham
        case "GET":
            $stmt = $conn->query("SELECT * FROM products");
            $products = $stmt->fetchAll();

            response(true, $products);
            break;

        // POST: Them san pham
        case "POST":
            $data = validateProduct(getInput());

            $sql = "INSERT INTO products (name, price, stock)
                    VALUES (:name, :price, :stock)";

            $stmt = $conn->prepare($sql);
            $stmt->execute($data);

            response(true, [
                "id" => $conn->lastInsertId(),
                "name" => $data["name"],
                "price" => $data["price"],
                "stock" => $data["stock"]
            ]);
            break;

        // PUT: Cap nhat san pham
        case "PUT":
            if (!isset($_GET["id"]) || !ctype_digit($_GET["id"]) || (int)$_GET["id"] <= 0) {
                response(false, null, "ID khong hop le", 400);
            }

            $id = (int)$_GET["id"];
            $data = validateProduct(getInput());

            $check = $conn->prepare("SELECT id FROM products WHERE id = :id");
            $check->execute(["id" => $id]);

            if (!$check->fetch()) {
                response(false, null, "San pham khong ton tai", 404);
            }

            $sql = "UPDATE products
                    SET name = :name, price = :price, stock = :stock
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $data["id"] = $id;
            $stmt->execute($data);

            response(true, ["message" => "Cap nhat san pham thanh cong"]);
            break;

        // DELETE: Xoa san pham
        case "DELETE":
            if (!isset($_GET["id"]) || !ctype_digit($_GET["id"]) || (int)$_GET["id"] <= 0) {
                response(false, null, "ID khong hop le", 400);
            }

            $id = (int)$_GET["id"];

            $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute(["id" => $id]);

            if ($stmt->rowCount() === 0) {
                response(false, null, "San pham khong ton tai", 404);
            }

            response(true, ["message" => "Xoa san pham thanh cong"]);
            break;

        default:
            response(false, null, "Phuong thuc khong duoc ho tro", 405);
    }

} catch (PDOException $e) {
    response(false, null, "Loi truy van co so du lieu", 500);
}
?>
