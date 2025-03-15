<?php
include '../includes/header.php';

// Securely get the student ID from URL
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
if (!$id) {
    header("Location: http://localhost:8000/");
    exit;
}

// Load students data
$studentsFile = '../student-db.json';
$studentsData = file_exists($studentsFile) ? json_decode(file_get_contents($studentsFile), true) ?: [] : [];

// Find the student by ID
$student = null;
foreach ($studentsData as $s) {
    if (isset($s['id']) && $s['id'] === $id) {
        $student = $s;
        break;
    }
}

// If student is not found, redirect to homepage
if (!$student) {
    header("Location: http://localhost:8000/");
    exit;
}
?>

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Edit Student</h2>
    <form action="../actions/edit_student.php" method="POST" class="mb-4 bg-white shadow-md rounded-lg p-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($student['id']) ?>">

        <div class="mb-2">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($student['name']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 p-2">
        </div>

        <div class="mb-2">
            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
            <input type="number" name="age" id="age" value="<?= htmlspecialchars($student['age']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 p-2">
        </div>

        <div class="mb-2">
            <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
            <input type="text" name="grade" id="grade" value="<?= htmlspecialchars($student['grade']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 p-2">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Update Student</button>
    </form>

    <a href="http://localhost:8000/" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 block text-center mt-2">Back</a>
</div>

<?php include '../includes/footer.php'; ?>
