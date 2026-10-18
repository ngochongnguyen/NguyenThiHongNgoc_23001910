<?php
session_start();

require_once __DIR__ . "/common/dbConnect.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    } else {
        $stmt = $conn->prepare(
            "SELECT id, username, password_hash
             FROM users
             WHERE username = :username"
        );

        $stmt->execute(["username" => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password_hash"])) {
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: product_list.php");
            exit;
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<body>
    <h1>Đăng nhập</h1>

    <?php if ($error !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label for="username">Tên đăng nhập:</label><br>
            <input type="text" id="username" name="username" required>
        </p>

        <p>
            <label for="password">Mật khẩu:</label><br>
            <input type="password" id="password" name="password" required>
        </p>

        <button type="submit">Đăng nhập</button>
    </form>

    <p><a href="register.php">Chưa có tài khoản? Đăng ký</a></p>
    <p><a href="product_list.php">Quay lại danh sách sản phẩm</a></p>
</body>
</html>
