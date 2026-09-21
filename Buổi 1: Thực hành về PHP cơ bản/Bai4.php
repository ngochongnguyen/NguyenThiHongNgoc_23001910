<?php

class Student
{
    // Thuộc tính
    public $name;
    public $age;
    public $score;

    // Constructor
    public function __construct($name, $age, $score)
    {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    // Method xếp loại
    public function getRank()
    {
        if ($this->score >= 8) {
            return "Giỏi";
        } elseif ($this->score >= 6.5) {
            return "Khá";
        } elseif ($this->score >= 5) {
            return "Trung bình";
        } else {
            return "Yếu";
        }
    }

    // Method kiểm tra đạt
    public function isPassed()
    {
        return $this->score >= 5;
    }

    // Method hiển thị thông tin
    public function display()
    {
        echo "Họ tên: " . $this->name . "<br>";
        echo "Tuổi: " . $this->age . "<br>";
        echo "Điểm: " . $this->score . "<br>";
        echo "Xếp loại: " . $this->getRank() . "<br>";
        echo "Kết quả: " . ($this->isPassed() ? "Đạt" : "Không đạt") . "<br>";
        echo "<br>";
    }
}


// Tạo các object Student
$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);


// Tạo danh sách các object Student
$students = [
    $student1,
    $student2,
    $student3,
    $student4
];


// Function tìm sinh viên có điểm cao nhất
function findBestStudent($students)
{
    $bestStudent = $students[0];

    foreach ($students as $student) {
        if ($student->score > $bestStudent->score) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}


// Function đếm số sinh viên đạt
function countPassedStudents($students)
{
    $count = 0;

    foreach ($students as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }

    return $count;
}


// Function tính điểm trung bình
function calculateAverageScore($students)
{
    $totalScore = 0;

    foreach ($students as $student) {
        $totalScore += $student->score;
    }

    return $totalScore / count($students);
}


// Hiển thị danh sách sinh viên
echo "<h3>Danh sách sinh viên</h3>";

foreach ($students as $student) {
    $student->display();
}


// Tìm sinh viên có điểm cao nhất
$bestStudent = findBestStudent($students);

echo "<h3>Sinh viên có điểm cao nhất</h3>";
echo "Họ tên: " . $bestStudent->name . "<br>";
echo "Điểm: " . $bestStudent->score . "<br><br>";


// Đếm số sinh viên đạt
$passedCount = countPassedStudents($students);

echo "<h3>Số sinh viên đạt</h3>";
echo $passedCount . "<br><br>";


// Tính điểm trung bình
$averageScore = calculateAverageScore($students);

echo "<h3>Điểm trung bình của lớp</h3>";
echo $averageScore;

?>