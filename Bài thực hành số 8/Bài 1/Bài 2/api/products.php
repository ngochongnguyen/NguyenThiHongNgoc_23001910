<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

// Ham tra ve JSON
function response($success, $message = "", $data = null, $status = 200) {
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

// Doc JSON tu request
function getInput() {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!is_array($input)) {
        response(false, "Invalid JSON data", null, 400);
    }

    return $input;
}

// Kiem tra du lieu san pham
function validateProduct($input) {
    $name = isset($input["name"]) && is_string($input["name"])
        ? trim($input["name"])
        : "";

    if (mb_strlen($name, "UTF-8") < 1 ||
        mb_strlen($name, "UTF-8") > 100) {
        response(false, "Name must contain 1 to 100 characters", null, 400);
    }

    // Kiem tra price
    $price = $input["price"] ?? null;

    if (!is_int($price) || $price <= 0) {
        response(false, "Price must be an integer greater than 0", null, 400);
    }

    // Kiem tra stock
    $stock = $input["stock"] ?? null;

    if (!is_int($stock) || $stock < 0) {
        response(false, "Stock must be a non-negative integer", null, 400);
    }

    return [
        "name" => $name,
        "price" => $price,
        "stock" => $stock
    ];
}

try {

    $method = $_SERVER["REQUEST_METHOD"];

    switch ($method) {

        // GET: Lay danh sach san pham
        case "GET":

            $sql = "SELECT * FROM products";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $products = $stmt->fetchAll();

            response(true, "", $products);

            break;


        // POST: Them san pham moi
        case "POST":

            $input = getInput();
            $product = validateProduct($input);

            $sql = "INSERT INTO products (name, price, stock)
                    VALUES (:name, :price, :stock)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ":name" => $product["name"],
                ":price" => $product["price"],
                ":stock" => $product["stock"]
            ]);

            response(true, "Product added successfully");

            break;


        // PUT: Cap nhat san pham
        case "PUT":

            $id = filter_var(
                $_GET["id"] ?? null,
                FILTER_VALIDATE_INT
            );

            if ($id === false || $id === null || $id <= 0) {
                response(false, "Invalid product ID", null, 400);
            }

            $input = getInput();
            $product = validateProduct($input);

            // Kiem tra san pham co ton tai
            $check = $conn->prepare(
                "SELECT id FROM products WHERE id = :id"
            );

            $check->execute([":id" => $id]);

            if (!$check->fetch()) {
                response(false, "Product not found", null, 404);
            }

            $sql = "UPDATE products
                    SET name = :name,
                        price = :price,
                        stock = :stock
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ":name" => $product["name"],
                ":price" => $product["price"],
                ":stock" => $product["stock"],
                ":id" => $id
            ]);

            response(true, "Product updated successfully");

            break;


        // DELETE: Xoa san pham
        case "DELETE":

            $id = filter_var(
                $_GET["id"] ?? null,
                FILTER_VALIDATE_INT
            );

            if ($id === false || $id === null || $id <= 0) {
                response(false, "Invalid product ID", null, 400);
            }

            $sql = "DELETE FROM products WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute([":id" => $id]);

            if ($stmt->rowCount() === 0) {
                response(false, "Product not found", null, 404);
            }

            response(true, "Product deleted successfully");

            break;


        // Phuong thuc khong duoc ho tro
        default:

            header("Allow: GET, POST, PUT, DELETE");

            response(false, "Method not allowed", null, 405);
    }

} catch (PDOException $e) {

    response(false, "Database error", null, 500);

} catch (Throwable $e) {

    response(false, "Server error", null, 500);
}

?>
