<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Student Management</h2>

        <form action="actions/add_student.php" method="POST" class="mb-4 bg-white shadow-md rounded-lg p-4">
            <div class="mb-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 p-2">
            </div>
            <div class="mb-2">
                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                <input type="number" name="age" id="age" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 p-2">
            </div>
            <div class="mb-2">
                <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                <input type="text" name="grade" id="grade" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 p-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Add Student</button>
        </form>

        <h3 class="text-xl font-semibold mb-2">Student List</h3>
        <div id="student-list" class="bg-white shadow rounded-lg p-4">
            <p id="loading-text" class="text-gray-500">Loading students...</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('actions/get_students.php')
                .then(response => response.json())
                .then(data => {
                    const studentList = document.getElementById('student-list');
                    studentList.innerHTML = '';

                    if (data.length === 0) {
                        studentList.innerHTML = '<p class="text-gray-500">No students found.</p>';
                        return;
                    }

                    data.forEach(student => {
                        const studentItem = document.createElement('div');
                        studentItem.className = 'flex justify-between items-center border-b py-2';

                        studentItem.innerHTML = `
                            <div>
                                <strong>${student.name}</strong> (Age: ${student.age}, Grade: ${student.grade})
                            </div>
                            <div>
                                <button onclick="editStudent('${student.id}')" class="text-blue-500 hover:underline mr-4">Edit</button>
                                <button onclick="deleteStudent('${student.id}')" class="text-red-500 hover:underline">Delete</button>
                            </div>
                        `;
                        studentList.appendChild(studentItem);
                    });
                })
                .catch(error => {
                    document.getElementById('student-list').innerHTML = '<p class="text-red-500">Error loading students.</p>';
                    console.error('Error fetching students:', error);
                });
        });

        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student?')) {
                fetch('actions/delete_student.php', {
                    method: 'POST',
                    body: new URLSearchParams({ id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => alert('Error deleting student.'));
            }
        }

        function editStudent(id) {
            window.location.href = `includes/edit_form.php?id=${id}`;
        }
    </script>

    <?php include 'includes/footer.php'; ?>
</body>

</html>
