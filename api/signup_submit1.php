<?php
require("../includes/database_connect.php");

$fullname = $_POST["full_name"];
$phone_number = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["password"];
$college_name = $_POST["college_name"];
$gender = $_POST["gender"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
if(!$result){
    $response = array("success" => false, "msg" => "An error occured");
    echo json_encode($response);
    return;
}
else if(mysqli_num_rows($result) > 0){
    $response = array("success" => false, "msg" => "An account already exists with this email address.");
    echo json_encode($response);
    return;
}

$sql = "INSERT INTO users(name,email,ph_no,pass,clg,gender) VALUES ('$fullname', '$email', '$phone_number', '$password', '$college_name', '$gender')";
$result = mysqli_query($conn,$sql);
if(!$result){
    $response = array("success" => false, "msg" => "An error occured");
    echo json_encode($response);
    return;
}

$response = array("success" => true, "msg" => "Account created successfully.");
echo json_encode($response);
mysqli_close($conn);
?>
