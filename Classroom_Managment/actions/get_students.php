<?php

header('Content-Type: application/json');

$studentsFile = '../student-db.json';

if (file_exists($studentsFile)) {
    $studentsData = file_get_contents($studentsFile);
    echo $studentsData;
} else {
    echo json_encode([]);
}
?>