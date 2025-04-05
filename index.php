<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<h2>Enter Student Details</h2>

<form action="insert.php" method="POST">
    <label>Student ID:</label>
    <input type="text" name="student_id" required>

    <label>Student Name:</label>
    <input type="text" name="student_name" required>

    <label>Gender:</label>
    <select name="gender" required>
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <label>Grade:</label>
    <input type="text" name="grade_id" required>

    <label>Academic Year:</label>
    <input type="text" name="academic_year" required>

    <h4>Enter Marks</h4>
    <?php
    $subjects = ["Maths", "English", "Biology", "Chemistry", "Physics"];
    foreach ($subjects as $subject) {
        echo "<label>$subject:</label>
              <input type='number' name='marks[$subject]' min='0' max='100' required>";
    }
    ?>

    <button type="submit">Submit</button>
</form>

</body>
</html>
