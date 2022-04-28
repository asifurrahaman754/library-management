<?php 
include "connection.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM `admin` WHERE `email`= '$email' AND `password`= '$password'";

$result = mysqli_query($con, $sql);
session_start();

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $_SESSION['admin_id'] = $row['id'];
    $_SESSION['admin_username'] = $row['username'];
    $_SESSION['admin_email'] = $row['email'];
    header("Location: admin/dashboard/index.php");
    
}else{
    $checkEmail = "SELECT * FROM `admin` WHERE email= '$email'";
    $checkEmail_result = mysqli_query($con, $checkEmail);
    if(mysqli_num_rows($checkEmail_result) > 0){
        header("Location: admin_login.php?error=Incorrect Password");
    }else{
        header("Location: admin_login.php?error=Incorrect Email");
    }
}

?>