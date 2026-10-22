<?php
// 1. Khai báo mảng chứa ít nhất 5 sản phẩm
$products = [
    ["name" => "Laptop", "price" => 15000000, "quantity" => 2],
    ["name" => "Điện thoại", "price" => 10000000, "quantity" => 3],
    ["name" => "Tai nghe", "price" => 500000, "quantity" => 5],
    ["name" => "Máy tính bảng", "price" => 8000000, "quantity" => 2],
    ["name" => "Màn hình", "price" => 4000000, "quantity" => 4]
];

// 2. Hàm tính tổng giá trị sản phẩm
function calculateTotal($products) {
    $total = 0;

    foreach ($products as $product) {
        $total += $product["price"];
    }

    return $total;
}

// 3. Hàm tìm giá sản phẩm cao nhất
function findMaxPrice($products) {
    $maxPrice = $products[0]["price"];

    foreach ($products as $product) {
        if ($product["price"] > $maxPrice) {
            $maxPrice = $product["price"];
        }
    }

    return $maxPrice;
}

// 4. Hàm tính tổng số lượng sản phẩm có giá cao nhất
function totalQuantity($products) {
    $totalQuantity = 0;
    $maxPrice = findMaxPrice($products);

    foreach ($products as $product) {
        if ($product["price"] == $maxPrice) {
            $totalQuantity += $product["quantity"];
        }
    }

    return $totalQuantity;
}

// 5. Gọi các hàm
$total = calculateTotal($products);
$maxPrice = findMaxPrice($products);
$totalMaxQuantity = totalQuantity($products);

// 6. Hiển thị kết quả
echo "Tổng giá trị sản phẩm: " . number_format($total) . " VNĐ<br>";
echo "Giá sản phẩm cao nhất: " . number_format($maxPrice) . " VNĐ<br>";
echo "Tổng số lượng sản phẩm có giá cao nhất: " . $totalMaxQuantity;
?>
