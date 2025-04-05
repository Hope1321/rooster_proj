<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "student_rostebr_db";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if student ID is provided
if (!isset($_GET['delete_student_id']) || empty($_GET['delete_student_id'])) {
    die("Error: No student ID provided.");
}

$student_id = $_GET['delete_student_id'];

// Begin transaction
$conn->begin_transaction();

try {
    // Delete marks for the student
    $sql_marks = $conn->prepare("DELETE FROM marks WHERE student_id = ?");
    $sql_marks->bind_param("s", $student_id);
    if (!$sql_marks->execute()) {
        throw new Exception("Error deleting marks: " . $conn->error);
    }

    // Delete performance record for the student
    $sql_performance = $conn->prepare("DELETE FROM performance WHERE student_id = ?");
    $sql_performance->bind_param("s", $student_id);
    if (!$sql_performance->execute()) {
        throw new Exception("Error deleting performance: " . $conn->error);
    }

    // Delete the student record
    $sql_student = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $sql_student->bind_param("s", $student_id);
    if (!$sql_student->execute()) {
        throw new Exception("Error deleting student: " . $conn->error);
    }

    // Commit transaction
    $conn->commit();

    // Success message and redirect
    echo "<script>alert('Student record deleted successfully!'); window.location='view.php';</script>";

} catch (Exception $e) {
    // Rollback if an error occurs
    $conn->rollback();
    echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location='view.php';</script>";
}

// Close connection
$conn->close();
?>
