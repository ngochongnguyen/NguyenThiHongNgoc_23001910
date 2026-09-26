<?php

class Movie
{
    private $id;
    private $title;
    private $price;
    private $totalSeats;
    private $availableSeats;

    public function __construct($id, $title, $price, $totalSeats)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function bookTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "Lỗi: Số vé đặt phải lớn hơn 0.<br>";
            return false;
        }

        if ($quantity > $this->availableSeats) {
            echo "Lỗi: Không đủ ghế trống cho phim "
                . $this->title . ".<br>";
            return false;
        }

        $this->availableSeats -= $quantity;

        echo "Đặt thành công " . $quantity
            . " vé cho phim " . $this->title . ".<br>";

        return true;
    }

    public function cancelTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "Lỗi: Số vé hủy phải lớn hơn 0.<br>";
            return false;
        }

        if ($quantity > $this->getSoldSeats()) {
            echo "Lỗi: Không thể hủy " . $quantity
                . " vé vì số vé đã bán không đủ.<br>";
            return false;
        }

        $this->availableSeats += $quantity;

        echo "Hủy thành công " . $quantity
            . " vé của phim " . $this->title . ".<br>";

        return true;
    }

    public function getSoldSeats()
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue()
    {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo()
    {
        echo "<h3>Thông tin phim</h3>";
        echo "Mã phim: " . $this->id . "<br>";
        echo "Tên phim: " . $this->title . "<br>";
        echo "Giá vé: " . number_format($this->price) . " VNĐ<br>";
        echo "Tổng số ghế: " . $this->totalSeats . "<br>";
        echo "Số ghế còn lại: " . $this->availableSeats . "<br>";
        echo "Số vé đã bán: " . $this->getSoldSeats() . "<br>";
        echo "Doanh thu: " . number_format($this->getRevenue())
            . " VNĐ<br>";
        echo "<hr>";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
