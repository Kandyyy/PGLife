<?php
require ("../includes/database_connect.php");
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "An error occured";
    exit;
}
else if(mysqli_num_rows($result) == 0){
    echo "Account not found. Please register first.";
    exit;
}

$sql = "SELECT * FROM users WHERE email = '$email' and pass = '$password'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "An error occured.";
    exit;
}
else if(mysqli_num_rows($result) == 0){
    echo "User not found.";
    exit;
}
$row = mysqli_fetch_assoc($result);
if ($row){
    $_SESSION["user_id"] = $row["id"];
    header("location: ../dashboard.php");
    exit;
}



mysqli_close($conn);
?>

