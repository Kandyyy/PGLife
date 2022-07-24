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
    echo "An error occured.";
    exit;
}
else if(mysqli_num_rows($result) > 0){
    echo "An account already exists with this email address.";
    exit;
}

$sql = "INSERT INTO users(name,email,ph_no,pass,clg,gender) VALUES ('$fullname', '$email', '$phone_number', '$password', '$college_name', '$gender')";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "An error occured";
    exit;
}

echo "Account created successfully.";
?>
Click <a href="../index.php">here</a> to continue.
<?php
mysqli_close($conn);