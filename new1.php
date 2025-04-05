<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Roster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pass-bg { background-color: #28a745; color: white; }
        .fail-bg { background-color: #dc3545; color: white; }
        .header-box { border: 2px solid #28a745; padding: 10px; background-color: #f8f9fa; }
        .note-box { margin-top: 20px; }
    </style>
</head>
<body class="container mt-4">

<!-- Header for the School Roster -->
<div class="text-center mb-4 header-box">
    <h2>ABC HIGH SCHOOL STUDENT ROSTER</h2>
    <p><strong>GRADE: 9A</strong></p>
    <p><strong>HOMEROOM TEACHER: UJULU</strong></p>
    <p><strong>ACADEMIC YEAR: 2016 | SEMESTER I</strong></p>
</div>

<!-- Table for student data -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">STUDENT NAME</th>
            <th rowspan="2">GENDER</th>
            <th rowspan="2">ID</th>
            <th colspan="5" class="text-center">SUBJECTS</th>
            <th rowspan="2">TOTAL</th>
            <th rowspan="2">AVG</th>
            <th rowspan="2">RANK</th>
            <th rowspan="2">STATUS</th>
        </tr>
        <tr>
            <th>MATHS</th>
            <th>ENG</th>
            <th>BIO</th>
            <th>CHEM</th>
            <th>PHY</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "student_rostebr_db";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch student data
    $sql = "SELECT s.student_name, s.gender, s.student_id, 
                   SUM(m.marks) AS total_marks, 
                   ROUND(AVG(m.marks), 1) AS avg_marks, 
                   p.rank, p.status, 
                   SUM(CASE WHEN m.subject_id = 'SUB001' THEN m.marks ELSE 0 END) AS maths_marks,
                   SUM(CASE WHEN m.subject_id = 'SUB002' THEN m.marks ELSE 0 END) AS english_marks,
                   SUM(CASE WHEN m.subject_id = 'SUB003' THEN m.marks ELSE 0 END) AS biology_marks,
                   SUM(CASE WHEN m.subject_id = 'SUB004' THEN m.marks ELSE 0 END) AS chemistry_marks,
                   SUM(CASE WHEN m.subject_id = 'SUB005' THEN m.marks ELSE 0 END) AS physics_marks
            FROM students s 
            JOIN marks m ON s.student_id = m.student_id 
            JOIN performance p ON s.student_id = p.student_id 
            GROUP BY s.student_id ORDER BY p.rank ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["student_name"] . "</td>";
            echo "<td>" . $row["gender"] . "</td>";
            echo "<td>" . $row["student_id"] . "</td>";
            echo "<td>" . $row["maths_marks"] . "</td>";
            echo "<td>" . $row["english_marks"] . "</td>";
            echo "<td>" . $row["biology_marks"] . "</td>";
            echo "<td>" . $row["chemistry_marks"] . "</td>";
            echo "<td>" . $row["physics_marks"] . "</td>";
            echo "<td>" . $row["total_marks"] . "</td>";
            echo "<td>" . $row["avg_marks"] . "</td>";
            echo "<td>" . $row["rank"] . "</td>";
            echo "<td class='" . ($row["status"] == "PASS" ? 'pass-bg' : 'fail-bg') . "'>" . $row["status"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='12' class='text-center'>No students found.</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>

<!-- Notes Section -->
<div class="note-box">
    <p><strong>NOTE:</strong></p>
    <ul>
        <li>SUBJECT LEVEL TOTAL = 100</li>
        <li>OVERALL TOTAL = 500</li>
        <li>PASS MARK = 50%</li>
        <li>Teachers have subject-based department. The subject will be assigned for one of the teacher from the department.</li>
        <li><strong>Homeroom Teacher:</strong> a teacher who collect student's mark from subject teachers and prepare a student roster.</li>
    </ul>
</div>

</body>
</html>