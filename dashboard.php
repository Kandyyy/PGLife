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

function male_female($gender){
    if($gender == "male"){
        return "img/male.png";
    }
    else if($gender == "female"){
        return "img/female.png";
    }
    else{
        return "img/unisex.png";
    }
}

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

    $sql = "SELECT * FROM interested_users_properties up INNER JOIN properties p ON up.property_id = p.id WHERE up.user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        echo "An error occured.";
        exit;
    }
    $interested_properties = mysqli_fetch_all($result,MYSQLI_ASSOC);
  ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2 px-3">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <div class="container" id="container">
        <div class="row" id="row">
            <div class="col-sm-12 col-md-3">
                <h1 class="myProfile">My Profile</h1>
                <img src="img/man.png" alt="profilepic" class="user-pfp">
            </div>
            <div class="col">
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
            <?php 
                if(count($interested_properties) == 0){
                    ?><h4 style="text-align:center">No interested Properties</h4><?php
                } 
                else{
                ?>
                
                <?php
                foreach ($interested_properties as $property) {
                    $property_image = glob("img/properties/".$property["id"]."/*");
                    }
                foreach($interested_properties as $property): ?>
        <div class="property-card row">
            <div class="image-container col-md-4">
                <img src="<?= $property_image[0] ?>"/>
            </div>
            <div class="content-container col-md-8">
                <div class="row no-gutters justify-content-between">
                        <?php
                            $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safe']) / 3;
                            $total_rating = round($total_rating, 1);
                        ?>
                    <div class="star-container" title="<?= $total_rating ?>">
                            <?php
                            $rating = $total_rating;
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                    </div>
                    <div class="interested-container">
                        <?php 
                            $interested_users = 0;
                            $interested = false;
                            foreach($interested_properties as $interested_property){
                                if($interested_property["property_id"] == $property["id"]){
                                    $interested_users++;
                                    if($interested_property["user_id"] == $user_id){
                                        $interested = true;
                                    }
                                }
                            }
                        ?>
                        <?php if($interested){ ?>
                            <i class="fas fa-heart"></i>
                        <?php }
                        else{ ?>
                        <i class="far fa-heart"></i>
                        <?php } 
                        ?>
                        
                        <div class="interested-text"><?= $interested_users ?></div>
                    </div>
                </div>
                <div class="detail-container">
                    <div class="property-name">
                        <?php 
                           echo $property["name"];
                        ?>
                </div>
                    <div class="property-address"><?= $property["address"] ?></div>
                    <div class="property-gender">
                        <img src= "<?= male_female($property["gender"]) ?>" />
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="rent-container col-6">
                        <div class="rent"><?= $property["rent"] ?></div>
                        <div class="rent-unit">per month</div>
                    </div>
                    <div class="button-container col-6">
                        <a href="property_detail.php?property_id=<?= $property["id"] ?>&city_id=<?= $property["city_id"] ?>&property_name=<?=$property['name']?>"  class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; }?>
        </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>