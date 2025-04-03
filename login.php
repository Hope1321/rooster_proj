<?php 
$Fname= "";
$password= "";
$err= "";

$conn= mysqli_connect("localhost", "root", "", "student_reg");
if(!$conn){
    die("the connection is failed".mysqli_connect_error());
}
if(isset($_POST['LOGIN'])){
    $Fname= mysqli_real_connect($conn, $_POST['Fname']);
    $password= mysqli_real_connect($conn, $_POST['Password']);
    $sql= "Select *  from User_reg where Fname= '".$Fname."' and Password= '".$Password."' limit 1";
    $result= mysqli_query($conn, $sql);
    if(empty($Fname)){
        $err= "User name is required";
    }
    elseif(empty($Password)){
        $err= "User password is required"; 
    }
    elseif(mysqli_num_rows($result == 1)){
        header('location: Home.php');
    }
    else{
        $err= "User Name or Password not correct";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/loginSty.css">
    <titleL>Login_System</title>
</head>
<body>
    <div class="box">
        <h1>LOGIN HERE</h1>
        <div class="err">
        <?php 
        echo "$err";
         ?>
        <form action="login.php" method="POST">
              <input type="text" name="Fname" id="" placeholder="Enter User Name" required>
              <input type="password" name="password" id="" placeholder="Enter Password"> 
             <input type="submit" name="LOGIN" value="LOGIN " id=""> <br>
             not Yet a member ? <a href="signup.php" style="color: blue;">SIGNUP</a>
        </form>
    </div>
</body>
</html>