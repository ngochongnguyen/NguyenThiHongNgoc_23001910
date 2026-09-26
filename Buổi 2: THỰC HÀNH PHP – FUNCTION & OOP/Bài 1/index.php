require_once "CartItem.php";
require_once "ShoppingCart.php";

// 1. Tạo object ShoppingCart
$cart = new ShoppingCart();

// 2. Tạo ít nhất 04 object CartItem
$item1 = new CartItem("Laptop", 15000000, 1);
$item2 = new CartItem("Chuột không dây", 500000, 2);
$item3 = new CartItem("Bàn phím", 800000, 1);
$item4 = new CartItem("Tai nghe", 1200000, 1);

// 3. Thêm sản phẩm vào giỏ hàng
echo "<h2>THÊM SẢN PHẨM</h2>";

$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);

// 4. Hiển thị toàn bộ giỏ hàng
echo "<hr>";
echo "<h2>GIỎ HÀNG BAN ĐẦU</h2>";
$cart->displayCart();

// 5. Tính và hiển thị tổng tiền
echo "<hr>";
echo "<h2>TỔNG TIỀN</h2>";

echo "Tổng tiền giỏ hàng: "
    . number_format($cart->calculateTotal())
    . " VNĐ<br>";

// 6. Xóa một sản phẩm theo tên
echo "<hr>";
echo "<h2>XÓA SẢN PHẨM</h2>";

$cart->removeItem("Bàn phím");


// 7. Hiển thị lại giỏ hàng sau khi xóa
echo "<hr>";
echo "<h2>GIỎ HÀNG SAU KHI XÓA</h2>";

$cart->displayCart();
