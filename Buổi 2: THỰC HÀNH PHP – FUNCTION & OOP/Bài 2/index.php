<?php

require_once "Movie.php";
// 1. TẠO DANH SÁCH CÁC OBJECT MOVIE
$movies = [];

$movie1 = new Movie(1, "Avengers", 100000, 100);
$movie2 = new Movie(2, "Avatar", 120000, 80);
$movie3 = new Movie(3, "Batman", 90000, 120);

$movies[] = $movie1;
$movies[] = $movie2;
$movies[] = $movie3;

// 2. FUNCTION TÌM PHIM THEO ID
function findMovieById($movies, $id)
{
    foreach ($movies as $movie) {
        if ($movie->getId() == $id) {
            return $movie;
        }
    }

    return null;
}

// 3. FUNCTION TÍNH TỔNG DOANH THU
function getTotalRevenue($movies)
{
    $totalRevenue = 0;

    foreach ($movies as $movie) {
        $totalRevenue += $movie->getRevenue();
    }

    return $totalRevenue;
}

// 4. FUNCTION TÌM PHIM BÁN CHẠY NHẤT
function getBestSellingMovie($movies)
{
    if (empty($movies)) {
        return null;
    }

    $bestSellingMovie = $movies[0];

    foreach ($movies as $movie) {
        if ($movie->getSoldSeats() > $bestSellingMovie->getSoldSeats()) {
            $bestSellingMovie = $movie;
        }
    }

    return $bestSellingMovie;
}

// 5. ĐẶT VÉ CHO AVENGERS
echo "<h2>ĐẶT VÉ</h2>";

$avengers = findMovieById($movies, 1);

if ($avengers !== null) {
    $avengers->bookTicket(30);
}

// 6. ĐẶT VÉ CHO AVATAR
$avatar = findMovieById($movies, 2);

if ($avatar !== null) {
    $avatar->bookTicket(20);
}

// 7. HỦY MỘT SỐ VÉ AVENGERS
echo "<br>";
echo "<h2>HỦY VÉ</h2>";

if ($avengers !== null) {
    $avengers->cancelTicket(5);
}

// 8. HIỂN THỊ THÔNG TIN TẤT CẢ PHIM
echo "<h2>THÔNG TIN CÁC PHIM</h2>";

foreach ($movies as $movie) {
    $movie->displayInfo();
}
// 9. TÍNH TỔNG DOANH THU
echo "<h2>TỔNG DOANH THU</h2>";

$totalRevenue = getTotalRevenue($movies);

echo "Tổng doanh thu: "
    . number_format($totalRevenue)
    . " VNĐ<br>";

// 10. TÌM PHIM BÁN CHẠY NHẤT
echo "<h2>PHIM BÁN CHẠY NHẤT</h2>";

$bestSellingMovie = getBestSellingMovie($movies);

if ($bestSellingMovie !== null) {
    echo "Phim bán chạy nhất: "
        . $bestSellingMovie->getTitle()
        . "<br>";

    echo "Số vé đã bán: "
        . $bestSellingMovie->getSoldSeats()
        . "<br>";
}

// 11. KIỂM TRA CÁC TRƯỜNG HỢP KHÔNG HỢP LỆ
echo "<h2>KIỂM TRA TRƯỜNG HỢP KHÔNG HỢP LỆ</h2>";

// Đặt vé <= 0
$avengers->bookTicket(0);

// Đặt vé vượt quá số ghế còn lại
$avengers->bookTicket(1000);

// Hủy vé <= 0
$avengers->cancelTicket(0);

// Hủy nhiều hơn số vé đã bán
$avengers->cancelTicket(1000);

// Tìm phim không tồn tại
$notFoundMovie = findMovieById($movies, 999);

if ($notFoundMovie === null) {
    echo "Không tìm thấy phim có ID = 999.<br>";
}

// 12. KIỂM TRA DANH SÁCH RỖNG
$emptyMovies = [];

echo "<br>";
echo "Tổng doanh thu danh sách rỗng: "
    . number_format(getTotalRevenue($emptyMovies))
    . " VNĐ<br>";

$bestEmptyMovie = getBestSellingMovie($emptyMovies);

if ($bestEmptyMovie === null) {
    echo "Danh sách phim rỗng, không có phim bán chạy nhất.<br>";
}
