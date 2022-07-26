<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Best PG's in Mumbai | PG Life</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/property_list.css" rel="stylesheet" />
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
    session_start();
    include "includes/header.php"; 
    require "includes/database_connect.php";
    if(isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
    }
    else{
        $user_id = NULL;
    }
    if(!isset($_GET["city"])){
        header("location: index.php");
        exit;
    }
    $city_name = $_GET["city"];
    $sql1 = "SELECT * FROM cities WHERE name = '$city_name'";
    $result = mysqli_query($conn,$sql1);
    if(!$result){
        echo "An error occured.";
        exit;
    }
    $city = mysqli_fetch_assoc($result);
    if(!$city){
        echo "We do not have any PGs for this city.";
        exit;
    }
    $city_id = $city["id"];
    $sql2 = "SELECT * FROM properties WHERE city_id = '$city_id'";    
    $result = mysqli_query($conn,$sql2);
    if(!$result){
        echo "An error occured.";
        exit;
    }
    $properties = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $sql3 = "SELECT * FROM interested_users_properties iup INNER JOIN properties p ON iup.property_id = p.id WHERE p.city_id = '$city_id'";
    $result = mysqli_query($conn, $sql3);
    if(!$result){
        echo "An error occured.";
        exit;
    }
    $interested_properties = mysqli_fetch_all($result,MYSQLI_ASSOC);
    ?>

    <div id="loading">
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= 
                    $city_name;
                ?>
            </li>
        </ol>
    </nav>

    <div class="page-container">
        <div class="filter-bar row justify-content-around">
            <div class="col-auto" data-toggle="modal" data-target="#filter-modal">
                <img src="img/filter.png" alt="filter" />
                <span>Filter</span>
            </div>
            <div class="col-auto">
                <img src="img/desc.png" alt="sort-desc" />
                <span>Highest rent first</span>
            </div>
            <div class="col-auto">
                <img src="img/asc.png" alt="sort-asc" />
                <span>Lowest rent first</span>
            </div>
        </div>
        <?php
        foreach ($properties as $property) {
            $property_image = glob("img/properties/".$property["id"]."/*");
            }
        ?>
        <?php foreach($properties as $property): ?>
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
                        <a href="property_detail.php?city_name=<?=$city_name?>&property_name=<?=$property['name']?>"  class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
    if (count($properties) == 0) {
        ?>
            <div class="no-property-container">
                <p>No PG to list</p>
            </div>
        <?php
        }
        ?>
    <div class="footer">
        <div class="page-container footer-container">
            <div class="footer-cities">
                <div class="footer-city">
                    <a href="property_list.php">PG in Delhi</a>
                </div>
                <div class="footer-city">
                    <a href="property_list.php">PG in Mumbai</a>
                </div>
                <div class="footer-city">
                    <a href="property_list.php">PG in Bangalore</a>
                </div>
                <div class="footer-city">
                    <a href="property_list.php">PG in Hyderabad</a>
                </div>
            </div>
            <div class="footer-copyright">© 2020 Copyright PG Life </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    ?>
</body>

</html>
