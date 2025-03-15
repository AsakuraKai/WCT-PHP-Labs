<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        die("<h2 style='color: red;'>All fields are required.</h2><a href='index.html'>Go back</a>");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<h2 style='color: red;'>Invalid email format.</h2><a href='index.html'>Go back</a>");
    }

    if ($password !== $confirm_password) {
        die("<h2 style='color: red;'>Passwords do not match.</h2><a href='index.html'>Go back</a>");
    }

    echo "<h2 style='color: green;'>Registration Successful!</h2>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p class='text-gray-700'><span class='font-medium'>Password:</span> ********</p>";
    echo "<a href='index.html'>Go back</a>";
} else {
    echo "<h2>Invalid Request</h2>";
}
?>
