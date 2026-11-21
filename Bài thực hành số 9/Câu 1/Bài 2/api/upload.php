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

// Chỉ chấp nhận POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Allow: POST");
    response(false, "Chỉ hỗ trợ phương thức POST", null, 405);
}

// Kiểm tra product_id
$productId = filter_input(
    INPUT_POST,
    "product_id",
    FILTER_VALIDATE_INT
);

if (!$productId || $productId <= 0) {
    response(false, "Mã sản phẩm không hợp lệ", null, 400);
}

// Kiểm tra file ảnh
if (!isset($_FILES["image"])) {
    response(false, "Vui lòng chọn ảnh sản phẩm", null, 400);
}

$file = $_FILES["image"];

// Kiểm tra lỗi upload
if ($file["error"] !== UPLOAD_ERR_OK) {
    response(false, "Upload ảnh thất bại. Mã lỗi: " . $file["error"], null, 400);
}

// Kiểm tra dung lượng tối đa 2 MB
$maxSize = 2 * 1024 * 1024;

if ($file["size"] > $maxSize) {
    response(false, "Ảnh không được vượt quá 2 MB", null, 400);
}

// Kiểm tra file tạm có hợp lệ không
if (!is_uploaded_file($file["tmp_name"])) {
    response(false, "File upload không hợp lệ", null, 400);
}

// Kiểm tra MIME thực tế bằng Fileinfo
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file["tmp_name"]);

$allowedTypes = [
    "image/jpeg" => "jpg",
    "image/png" => "png"
];

if (!isset($allowedTypes[$mimeType])) {
    response(false, "Chỉ chấp nhận ảnh JPG, JPEG hoặc PNG", null, 400);
}

// Kiểm tra nội dung ảnh
$imageInfo = @getimagesize($file["tmp_name"]);

if (
    $imageInfo === false ||
    $imageInfo["mime"] !== $mimeType
) {
    response(false, "Nội dung file không phải ảnh hợp lệ", null, 400);
}

// Kiểm tra sản phẩm có tồn tại không
$stmt = $conn->prepare(
    "SELECT image FROM products WHERE id = ?"
);

$stmt->bind_param("i", $productId);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    response(false, "Sản phẩm không tồn tại", null, 404);
}

$product = $result->fetch_assoc();
$oldImage = $product["image"];

// Tạo tên file duy nhất
$extension = $allowedTypes[$mimeType];

$fileName = bin2hex(random_bytes(16)) . "." . $extension;

// Thư mục lưu ảnh
$uploadDir = __DIR__ . "/../../uploads/";

// Tạo thư mục nếu chưa tồn tại
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        response(false, "Không thể tạo thư mục uploads", null, 500);
    }
}

// Đường dẫn vật lý
$destination = $uploadDir . $fileName;

// Đường dẫn lưu trong database
$imagePath = "../uploads/" . $fileName;

// Di chuyển ảnh mới vào thư mục
if (!move_uploaded_file($file["tmp_name"], $destination)) {
    response(false, "Không thể lưu ảnh lên máy chủ", null, 500);
}

// Cập nhật đường dẫn ảnh vào database
$update = $conn->prepare(
    "UPDATE products SET image = ? WHERE id = ?"
);

$update->bind_param("si", $imagePath, $productId);

if (!$update->execute()) {
    // Nếu cập nhật database thất bại, xóa file mới
    if (is_file($destination)) {
        unlink($destination);
    }

    response(false, "Không thể cập nhật đường dẫn ảnh", null, 500);
}

// Xóa ảnh cũ sau khi ảnh mới đã được lưu thành công
if (!empty($oldImage)) {
    $oldFileName = basename($oldImage);
    $oldFilePath = $uploadDir . $oldFileName;

    if (
        $oldFileName !== $fileName &&
        is_file($oldFilePath)
    ) {
        unlink($oldFilePath);
    }
}

response(true, "Upload ảnh thành công", [
    "product_id" => $productId,
    "image" => $imagePath
]);
