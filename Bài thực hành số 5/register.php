<?php
require_once __DIR__ . "/common/dbConnect.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if ($username === "" || $password === "" || $confirmPassword === "") {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    } elseif (strlen($username) < 3) {
        $error = "Tên đăng nhập phải có ít nhất 3 ký tự.";
    } elseif (strlen($password) < 8) {
        $error = "Mật khẩu phải có ít nhất 8 ký tự.";
    } elseif ($password !== $confirmPassword) {
        $error = "Mật khẩu xác nhận không khớp.";
    } else {
        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE username = :username"
        );
        $stmt->execute(["username" => $username]);

        if ($stmt->fetch()) {
            $error = "Tên đăng nhập đã tồn tại.";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (username, password_hash)
                 VALUES (:username, :password_hash)"
            );

            $stmt->execute([
                "username" => $username,
                "password_hash" => $passwordHash
            ]);

            $success = "Đăng ký thành công! Em có thể đăng nhập.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
</head>
<body>
    <h1>Đăng ký tài khoản</h1>

    <?php if ($error !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <p style="color: green;">
            <?= htmlspecialchars($success) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label for="username">Tên đăng nhập:</label><br>
            <input
                type="text"
                id="username"
                name="username"
                minlength="3"
                required
            >
        </p>

        <p>
            <label for="password">Mật khẩu:</label><br>
            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                required
            >
        </p>

        <p>
            <label for="confirm_password">Nhập lại mật khẩu:</label><br>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                minlength="8"
                required
            >
        </p>

        <button type="submit">Đăng ký</button>
    </form>

    <p><a href="login.php">Đã có tài khoản? Đăng nhập</a></p>
    <p><a href="product_list.php">Quay lại danh sách sản phẩm</a></p>
</body>
</html>
