<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_rostebr_db";  // Ensure this is the correct DB name!

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if delete request is made
if (isset($_GET['delete_student_id'])) {
    $student_id = $_GET['delete_student_id'];

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Delete performance record for the student
        $sql_performance = $conn->prepare("DELETE FROM performance WHERE student_id = ?");
        $sql_performance->bind_param("s", $student_id);
        $sql_performance->execute();

        // Delete marks record for the student
        $sql_marks = $conn->prepare("DELETE FROM marks WHERE student_id = ?");
        $sql_marks->bind_param("s", $student_id);
        $sql_marks->execute();

        // Delete student record from students table
        $sql_student = $conn->prepare("DELETE FROM students WHERE student_id = ?");
        $sql_student->bind_param("s", $student_id);
        $sql_student->execute();

        // Commit the transaction
        $conn->commit();
        echo "Student and their related data deleted successfully!<br>";

    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

// Insert student data if POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve POST values
    $student_id = $_POST["student_id"];
    $student_name = $_POST["student_name"];
    $gender = $_POST["gender"];
    $grade_id = $_POST["grade_id"];
    $academic_year = $_POST["academic_year"];
    $marks = $_POST["marks"]; // marks is an associative array with subject names

    // Check if all required fields are filled
    if ($student_id && $student_name && $gender && $grade_id && $academic_year && count($marks) > 0) {

        // Begin a transaction
        $conn->begin_transaction();

        try {
            // Insert student details into the students table
            $sql_student = $conn->prepare("INSERT INTO students (student_id, student_name, gender, grade_id, academic_year) 
                                          VALUES (?, ?, ?, ?, ?)");
            $sql_student->bind_param("sssss", $student_id, $student_name, $gender, $grade_id, $academic_year);
            $sql_student->execute();

            // Insert performance data for the student
            $sql_performance = $conn->prepare("INSERT INTO performance (student_id) VALUES (?)");
            $sql_performance->bind_param("s", $student_id);
            $sql_performance->execute();

            // Insert marks into the marks table
            foreach ($marks as $subject => $mark) {
                $subject_id = getSubjectId($conn, $subject);
                if ($subject_id) {
                    $sql_marks = $conn->prepare("INSERT INTO marks (student_id, subject_id, marks) 
                                                 VALUES (?, ?, ?)");
                    $sql_marks->bind_param("ssi", $student_id, $subject_id, $mark);
                    $sql_marks->execute();
                } else {
                    throw new Exception("Subject $subject not found.");
                }
            }

            // After marks are inserted, update the rank and status
            updateRankAndStatus($conn);

            // Commit the transaction
            $conn->commit();
            echo "Student registered and data inserted successfully!<br>";
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }

    } else {
        echo "Please fill in all required fields!<br>";
    }
}

// Function to get subject_id by subject name
function getSubjectId($conn, $subject_name) {
    $sql = $conn->prepare("SELECT subject_id FROM subjects WHERE subject_name = ?");
    $sql->bind_param("s", $subject_name);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['subject_id'];
    }
    return null;
}

// Function to update rank and status based on marks
function updateRankAndStatus($conn) {
    // Set rank based on average marks (higher average gets a better rank)
    $rank_sql = "UPDATE performance p
                 JOIN (
                     SELECT s.student_id, ROUND(AVG(m.marks), 1) AS avg_marks
                     FROM students s
                     JOIN marks m ON s.student_id = m.student_id
                     GROUP BY s.student_id
                     ORDER BY avg_marks DESC
                 ) AS avg_marks_table
                 ON p.student_id = avg_marks_table.student_id
                 SET p.rank = (@rank := @rank + 1)";

    // Initialize rank variable
    $conn->query("SET @rank = 0");

    // Execute rank update
    if ($conn->query($rank_sql) === TRUE) {
        echo "Ranks updated successfully!<br>";
    } else {
        echo "Error updating ranks: " . $conn->error . "<br>";
    }

    // Set status based on average marks (PASS if >= 50, otherwise FAIL)
    $status_sql = "UPDATE performance p
                   JOIN (
                       SELECT s.student_id, ROUND(AVG(m.marks), 1) AS avg_marks
                       FROM students s
                       JOIN marks m ON s.student_id = m.student_id
                       GROUP BY s.student_id
                   ) AS avg_marks_table
                   ON p.student_id = avg_marks_table.student_id
                   SET p.status = IF(avg_marks_table.avg_marks >= 50, 'PASS', 'FAIL')";

    // Execute status update
    if ($conn->query($status_sql) === TRUE) {
        echo "Status updated successfully!<br>";
    } else {
        echo "Error updating status: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
