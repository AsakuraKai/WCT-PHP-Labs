<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Get student ID from POST request
$studentId = $_POST['id'] ?? '';

if (empty($studentId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid student ID.']);
    exit;
}

$studentsFile = '../student-db.json';

// Check if the file exists
if (!file_exists($studentsFile)) {
    echo json_encode(['success' => false, 'message' => 'Students file not found.']);
    exit;
}

// Read the file
$fileContent = file_get_contents($studentsFile);
if ($fileContent === false) {
    echo json_encode(['success' => false, 'message' => 'Could not read students file.']);
    exit;
}

// Decode JSON data
$studentsData = json_decode($fileContent, true);

// Check for decoding errors
if (!is_array($studentsData)) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data.']);
    exit;
}

// Find student by ID and remove them
$found = false;
foreach ($studentsData as $key => $student) {
    if (isset($student['id']) && $student['id'] === $studentId) {
        unset($studentsData[$key]);
        $found = true;
        break;
    }
}

if (!$found) {
    echo json_encode(['success' => false, 'message' => 'Student not found.']);
    exit;
}

// Re-index array to maintain order
$studentsData = array_values($studentsData);

// Save updated students list
if (file_put_contents($studentsFile, json_encode($studentsData, JSON_PRETTY_PRINT)) !== false) {
    echo json_encode(['success' => true, 'message' => 'Student deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Could not write to students file.']);
}
?>
