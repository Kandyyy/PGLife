<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    session_start();
    include "includes/head_links.php";
    require "includes/database_connect.php";
  ?>
    <title>Dashboard|PGLife</title>
</head>

<body>
<?php
    if(!isset($_SESSION["user_id"])){
        header("location: index.php");
        die();
    }
    include "includes/header.php";
    $user_id = $_SESSION["user_id"];
    $result = mysqli_query($conn,"SELECT * FROM users WHERE id = '$user_id'");
    if(!$result){
        echo "An error occured.";
        exit;
    }
    $data = mysqli_fetch_assoc($result);
    if(!$data){
        echo "An error occured.";
        exit;
    }
  ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2 px-3">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <div class="container" id="container">
        <div class="row" id="row">
            <div class="col-3">
                <h1>My Profile</h1>
                <img src="img/man.png" alt="" class="user-pfp">
            </div>
            <div class="col-7">
                <div class="user-info">
                    <h3><?= $data["name"]; ?></h3>
                    <h6><?= $data["email"] ?></h6>
                    <p><?= $data["clg"] ?></p>
                </div>
            </div>
            <div class="col-2 align-self-center">
                <p><a href="index.php">Edit profile</a></p>
            </div>
        </div>
    </div>
    <h2 class="properties-title">Interested Properties</h2>
    <div class="colorB">
        <div class="page-container">
            <div class="property-card row">
                <div class="image-container col-md-4">
                    <img src="img/properties/1/1d4f0757fdb86d5f.jpg">
                </div>
                <div class="content-container col-md-8">
                    <div class="row no-gutters justify-content-between">
                        <div class="star-container" title="4.5">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="interested-container">
                            <i class="far fa-heart"></i>
                            <div class="interested-text">3 interested</div>
                        </div>
                    </div>
                    <div class="detail-container">
                        <div class="property-name">Navkar Paying Guest</div>
                        <div class="property-address">44, Juhu Scheme, Juhu, Mumbai, Maharashtra 400058</div>
                        <div class="property-gender">
                            <img src="img/male.png">
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="rent-container col-6">
                            <div class="rent">Rs 9,500/-</div>
                            <div class="rent-unit">per month</div>
                        </div>
                        <div class="button-container col-6">
                            <a href="property_detail.php" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>