
CREATE DATABASE student_roster_db;
USE student_roster_db;

-- Table for storing student details
CREATE TABLE students (
    student_id VARCHAR(20) PRIMARY KEY,
    student_name VARCHAR(50),
    gender ENUM('M', 'F'),
    grade_id VARCHAR(10),
    academic_year VARCHAR(20)
);

-- Table for storing grades
CREATE TABLE grades (
    grade_id VARCHAR(10) PRIMARY KEY,
    grade_name VARCHAR(10),
    homeroom_teacher_id VARCHAR(20),
    academic_year VARCHAR(20)
);

-- Table for storing teachers
CREATE TABLE teachers (
    teacher_id VARCHAR(20) PRIMARY KEY,
    teacher_name VARCHAR(50),
    department VARCHAR(50)
);

-- Table for storing subjects
CREATE TABLE subjects (
    subject_id VARCHAR(10) PRIMARY KEY,
    subject_name VARCHAR(50),
    assigned_teacher_id VARCHAR(20)
);

-- Table for storing marks
CREATE TABLE marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20),
    subject_id VARCHAR(10),
    marks INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id)
);

-- Table for storing performance details
CREATE TABLE performance (
    student_id VARCHAR(20) PRIMARY KEY,
    total_marks INT,
    average_marks DECIMAL(5,2),
    rank INT,
    status ENUM('PASS', 'FAIL'),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);
