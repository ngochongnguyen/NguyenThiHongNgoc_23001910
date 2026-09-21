<?php

$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

// 1. Tìm sinh viên có điểm cao nhất
function findBestStudent($students)
{
    $bestStudent = $students[0];

    foreach ($students as $student) {
        if ($student["score"] > $bestStudent["score"]) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

// 2. Tìm sinh viên có điểm thấp nhất
function findWorstStudent($students)
{
    $worstStudent = $students[0];

    foreach ($students as $student) {
        if ($student["score"] < $worstStudent["score"]) {
            $worstStudent = $student;
        }
    }

    return $worstStudent;
}

// 3. Đếm số sinh viên đạt
function countPassedStudents($students)
{
    $count = 0;

    foreach ($students as $student) {
        if ($student["score"] >= 5) {
            $count++;
        }
    }

    return $count;
}

// 4. Tìm sinh viên theo tên
function findStudentByName($students, $name)
{
    foreach ($students as $student) {
        if ($student["name"] == $name) {
            return $student;
        }
    }

    return null;
}


// Gọi các function

$bestStudent = findBestStudent($students);

echo "Sinh viên có điểm cao nhất:<br>";
echo "Họ tên: " . $bestStudent["name"] . "<br>";
echo "Điểm: " . $bestStudent["score"] . "<br><br>";


$worstStudent = findWorstStudent($students);

echo "Sinh viên có điểm thấp nhất:<br>";
echo "Họ tên: " . $worstStudent["name"] . "<br>";
echo "Điểm: " . $worstStudent["score"] . "<br><br>";


$passedCount = countPassedStudents($students);

echo "Số sinh viên đạt: " . $passedCount . "<br><br>";


$foundStudent = findStudentByName($students, "Tran Thi Binh");

echo "Kết quả tìm kiếm sinh viên Tran Thi Binh:<br>";

if ($foundStudent != null) {
    echo "Họ tên: " . $foundStudent["name"] . "<br>";
    echo "Tuổi: " . $foundStudent["age"] . "<br>";
    echo "Điểm: " . $foundStudent["score"] . "<br>";
} else {
    echo "Không tìm thấy sinh viên.";
}

?>