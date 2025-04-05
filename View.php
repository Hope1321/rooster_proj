<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Roster</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2, p {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .bg-success {
            background-color: green;
            color: white;
            font-weight: bold;
        }
        .bg-danger {
            background-color: red;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Header for the School Roster -->
<div>
    <h2>ABC HIGH SCHOOL STUDENT ROSTER</h2>
    <p><strong>GRADE: 9A</strong></p>
    <p><strong>HOMEROOM TEACHER: UJULU</strong></p>
    <p><strong>ACADEMIC YEAR: 2017 | SEMESTER I</strong></p>
</div>

<!-- Table for student data -->
<table>
    <tr>
        <th>STUDENT NAME</th><th>GENDER</th><th>ID</th>
        <th>Maths</th><th>English</th><th>Biology</th><th>Chemistry</th><th>Physics</th>
        <th>TOTAL</th><th>AVG</th><th>RANK</th><th>STATUS</th><th>ACTION</th>
    </tr>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "student_rostebr_db";  // Ensure correct DB name

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT s.student_name, s.gender, s.student_id, 
                   SUM(m.marks) AS total_marks, 
                   ROUND(AVG(m.marks), 1) AS avg_marks, 
                   p.rank, p.status, 
                   SUM(CASE WHEN m.subject_id = '1' THEN m.marks ELSE 0 END) AS maths_marks,
                   SUM(CASE WHEN m.subject_id = '2' THEN m.marks ELSE 0 END) AS english_marks,
                   SUM(CASE WHEN m.subject_id = '3' THEN m.marks ELSE 0 END) AS biology_marks,
                   SUM(CASE WHEN m.subject_id = '4' THEN m.marks ELSE 0 END) AS chemistry_marks,
                   SUM(CASE WHEN m.subject_id = '5' THEN m.marks ELSE 0 END) AS physics_marks
            FROM students s 
            JOIN marks m ON s.student_id = m.student_id 
            JOIN performance p ON s.student_id = p.student_id 
            GROUP BY s.student_id ORDER BY p.rank ASC";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["student_name"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["student_id"] . "</td>";
        echo "<td>" . (isset($row["maths_marks"]) ? $row["maths_marks"] : '') . "</td>";
        echo "<td>" . (isset($row["english_marks"]) ? $row["english_marks"] : '') . "</td>";
        echo "<td>" . (isset($row["biology_marks"]) ? $row["biology_marks"] : '') . "</td>";
        echo "<td>" . (isset($row["chemistry_marks"]) ? $row["chemistry_marks"] : '') . "</td>";
        echo "<td>" . (isset($row["physics_marks"]) ? $row["physics_marks"] : '') . "</td>";
        echo "<td>" . $row["total_marks"] . "</td>";
        echo "<td>" . $row["avg_marks"] . "</td>";
        echo "<td>" . $row["rank"] . "</td>";
        echo "<td class='" . ($row["status"] == "PASS" ? 'bg-success' : 'bg-danger') . "'>" . $row["status"] . "</td>";
        echo "<td><a href='delete.php?delete_student_id=" . $row["student_id"] . "'>Delete</a></td>";
        echo "</tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>
