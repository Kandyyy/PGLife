<?php
require ("../includes/database_connect.php");
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn,$sql);
if(!$result){
    $response = array("success" => false, "msg"=>"An error occured");
    echo json_encode($response);
    return;
}
else if(mysqli_num_rows($result) == 0){
    $response = array("success" => false, "msg"=>"Account not found. Please register first.");
    echo json_encode($response);
    return;
}

$sql = "SELECT * FROM users WHERE email = '$email' and pass = '$password'";
$result = mysqli_query($conn,$sql);
if(!$result){
    $response = array("success" => false, "msg"=>"An error occured");
    echo json_encode($response);
    return;
}
else if(mysqli_num_rows($result) == 0){
    $response = array("success" => false, "msg"=>"User not found");
    echo json_encode($response);
    return;
}
$row = mysqli_fetch_assoc($result);
$_SESSION["user_id"] = $row["id"];
$response = array("success" => true, "msg"=>"Login Successful!");
echo json_encode($response);

mysqli_close($conn);
?>

