<?php 

$conn= mysqli_connect("localhost", "root", "", "Student_reg");
if(!$conn){
    die("The connection is Failed!!".mysqli_connect_error());
}
$sql= "CREATE TABLE User_reg(
    Id int(5) AUTO_INCREMENT primary key,
    Fname varchar(50) NOT NULL UNIQUE,
    Lname varchar(50) NOT NULL UNIQUE,
    Sex varchar (10) NOT NULL ,
    Email varchar(60) NOT NULL UNIQUE,
    Password varchar(50) NOT NULL UNIQUE,
    conf_pass varchar(50) NOT NULL UNIQUE,
    Reg_date timestamp default current_timestamp on update current_timestamp
     )";
if(mysqli_query($conn, $sql)){
    echo "TABLE are created";
}
else{
    echo " db connedct is failed";
}

?>