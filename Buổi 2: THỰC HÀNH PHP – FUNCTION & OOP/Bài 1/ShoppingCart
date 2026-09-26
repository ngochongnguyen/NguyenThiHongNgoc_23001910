<?php
class ShoppingCart
{
    private $items = [];

    public function addItem($item)
    {
        if (!($item instanceof CartItem)) {
            echo "Lỗi: Chỉ được thêm object CartItem vào giỏ hàng.<br>";
            return;
        }

        if ($item->getPrice() <= 0) {
            echo "Không thể thêm sản phẩm " . $item->getName()
                . ": giá sản phẩm phải lớn hơn 0.<br>";
            return;
        }

        if ($item->getQuantity() <= 0) {
            echo "Không thể thêm sản phẩm " . $item->getName()
                . ": số lượng phải lớn hơn 0.<br>";
            return;
        }

        $this->items[] = $item;

        echo "Đã thêm sản phẩm " . $item->getName() . " vào giỏ hàng.<br>";
    }

    public function removeItem($name)
    {
        foreach ($this->items as $index => $item) {
            if ($item->getName() === $name) {
                unset($this->items[$index]);

                // Đánh lại chỉ số của mảng
                $this->items = array_values($this->items);

                echo "Đã xóa sản phẩm " . $name . " khỏi giỏ hàng.<br>";
                return;
            }
        }

        echo "Không tìm thấy sản phẩm " . $name . " trong giỏ hàng.<br>";
    }

    public function calculateTotal()
    {
        $total = 0;

        foreach ($this->items as $item) {
            // Phải gọi getTotal() theo yêu cầu đề bài
            $total += $item->getTotal();
        }

        return $total;
    }

    public function displayCart()
    {
        if (empty($this->items)) {
            echo "<p>Giỏ hàng đang trống.</p>";
            return;
        }

        echo "<h3>Danh sách sản phẩm trong giỏ hàng</h3>";

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>";
        echo "<th>Tên sản phẩm</th>";
        echo "<th>Đơn giá</th>";
        echo "<th>Số lượng</th>";
        echo "<th>Thành tiền</th>";
        echo "</tr>";

        foreach ($this->items as $item) {
            echo "<tr>";
            echo "<td>" . $item->getName() . "</td>";
            echo "<td>" . number_format($item->getPrice()) . " VNĐ</td>";
            echo "<td>" . $item->getQuantity() . "</td>";
            echo "<td>" . number_format($item->getTotal()) . " VNĐ</td>";
            echo "</tr>";
        }

        echo "</table>";

        echo "<p><strong>Tổng tiền: "
            . number_format($this->calculateTotal())
            . " VNĐ</strong></p>";
    }
}
