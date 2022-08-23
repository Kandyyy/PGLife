<?php
    session_start();
    require "../includes/database_connect.php";

    if(!isset($_SESSION["user_id"])){
        echo json_encode(array("success" => false, "is_logged_in" => false));
        return;
    }

    $user_id = $_SESSION["user_id"];
    $property_id = $_GET["property_id"];

    $sql1 = "SELECT * FROM interested_users_properties where user_id = $user_id AND property_id = $property_id";
    $result = mysqli_query($conn, $sql1);
    if(!$result){
        echo json_encode(array("success" => false, "msg" => "Something went wrong"));
        return;
    }
    if(mysqli_num_rows($result) > 0){
        $sql2 = "DELETE FROM interested_users_properties WHERE property_id = $property_id AND user_id = $user_id";
        $result2 = mysqli_query($conn, $sql2);
        if(!$result2){
            echo json_encode(array("success" => false, "msg" => "Something went wrong"));
            return;
        }
        else{
            echo json_encode(array("success"=>true, "is_interested" => false, "property_id" => $property_id));
            return;
        }
    }
    else{
        $sql2 = "INSERT INTO interested_users_properties(property_id, user_id) VALUES ('$property_id', '$user_id')";
        $result2 = mysqli_query($conn, $sql2);
        if(!$result2){
            echo json_encode(array("success" => false, "msg" => "Something went wrong"));
            return;
        }
        else{
            echo json_encode(array("success"=>true, "is_interested" => true, "property_id" => $property_id));
            return;
        }
    }
?>
