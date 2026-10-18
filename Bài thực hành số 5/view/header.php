<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? "Quản lý sản phẩm") ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }

        h1 {
            color: #333;
        }

        a {
            color: #0645ad;
            text-decoration: none;
            margin-right: 8px;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input {
            padding: 8px;
            margin-top: 5px;
        }

        button {
            padding: 8px 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
