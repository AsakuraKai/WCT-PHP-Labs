<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use trim() to remove whitespace and htmlspecialchars() for security
    $name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8')) : '';
    $age = isset($_POST['age']) ? trim($_POST['age']) : '';
    $grade = isset($_POST['grade']) ? trim($_POST['grade']) : '';

    // Validate required fields
    if (empty($name) || empty($age) || empty($grade)) {
        header('Location: ../index.php?error=All fields are required');
        exit;
    }

    // Ensure age is a valid positive integer
    if (!ctype_digit($age) || (int)$age < 1) {
        header('Location: ../index.php?error=Invalid age');
        exit;
    }

    // Ensure grade is a valid integer (between 1 and 12)
    if (!ctype_digit($grade) || (int)$grade < 1 || (int)$grade > 12) {
        header('Location: ../index.php?error=Invalid grade');
        exit;
    }

    // Load existing student data
    $studentsFile = '../student-db.json';
    $studentsData = [];

    if (file_exists($studentsFile)) {
        $jsonContent = file_get_contents($studentsFile);
        $studentsData = json_decode($jsonContent, true) ?? [];
    }

    // Add new student
    $newStudent = [
        'id' => uniqid(),
        'name' => $name,
        'age' => (int)$age,
        'grade' => (int)$grade
    ];
    $studentsData[] = $newStudent;

    // Save to file
    if (file_put_contents($studentsFile, json_encode($studentsData, JSON_PRETTY_PRINT))) {
        header('Location: ../index.php?success=Student added successfully');
    } else {
        header('Location: ../index.php?error=Failed to save student');
    }
    exit;
}

// Redirect if accessed directly
header('Location: ../index.php');
exit;
?>
