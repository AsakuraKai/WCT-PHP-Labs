<?php
class Student {
    private $name;
    private $age;
    private $grade;
    private static $filePath = '../student-db.json';

    public function __construct($name, $age, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
    }

    public function getName() {
        return $this->name;
    }

    public function getAge() {
        return $this->age;
    }

    public function getGrade() {
        return $this->grade;
    }

    public static function addStudent($student) {
        $students = self::fetchStudents();
        $students[] = [
            'name' => $student->getName(),
            'age' => $student->getAge(),
            'grade' => $student->getGrade()
        ];
        self::saveStudents($students);
    }

    public static function editStudent($index, $student) {
        $students = self::fetchStudents();
        if (isset($students[$index])) {
            $students[$index] = [
                'name' => $student->getName(),
                'age' => $student->getAge(),
                'grade' => $student->getGrade()
            ];
            self::saveStudents($students);
        }
    }

    public static function deleteStudent($index) {
        $students = self::fetchStudents();
        if (isset($students[$index])) {
            unset($students[$index]);
            self::saveStudents(array_values($students));
        }
    }

    public static function getAllStudents() {
        return self::fetchStudents();
    }

    private static function fetchStudents() {
        if (file_exists(self::$filePath)) {
            $data = file_get_contents(self::$filePath);
            return json_decode($data, true) ?: [];
        }
        return [];
    }

    private static function saveStudents($students) {
        file_put_contents(self::$filePath, json_encode($students, JSON_PRETTY_PRINT));
    }
}
?>
