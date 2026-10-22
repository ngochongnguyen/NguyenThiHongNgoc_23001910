<?php
$name = "";
$score = "";
$result = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $scoreInput = trim($_POST["score"] ?? "");

    if (
        $name === "" ||
        $scoreInput === "" ||
        !is_numeric($scoreInput) ||
        (float)$scoreInput < 0 ||
        (float)$scoreInput > 10
    ) {
        $error = "Vui lòng nhập tên và điểm hợp lệ (0–10).";
    } else {
        $score = (float)$scoreInput;

        if ($score >= 8) {
            $result = "Giỏi";
        } elseif ($score >= 6.5) {
            $result = "Khá";
        } elseif ($score >= 5) {
            $result = "Trung bình";
        } else {
            $result = "Yếu";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xếp loại học sinh</title>
</head>
<body>
    <h1>Xếp loại học sinh</h1>

    <?php if ($error !== ""): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label for="name">Tên học sinh:</label>
            <input type="text" id="name" name="name"
                value="<?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?>"
                required>
        </p>

        <p>
            <label for="score">Điểm:</label>
            <input type="number" id="score" name="score"
                min="0" max="10" step="0.1"
                value="<?= htmlspecialchars($scoreInput ?? "", ENT_QUOTES, "UTF-8") ?>"
                required>
        </p>

        <button type="submit">Xếp loại</button>
    </form>

    <?php if ($result !== ""): ?>
        <h2>Kết quả học tập</h2>
        <p>Tên học sinh: <?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?></p>
        <p>Điểm: <?= htmlspecialchars((string)$score, ENT_QUOTES, "UTF-8") ?></p>
        <p>Xếp loại: <?= htmlspecialchars($result, ENT_QUOTES, "UTF-8") ?></p>
    <?php endif; ?>
</body>
</html>
