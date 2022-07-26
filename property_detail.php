<!DOCTYPE html>
<html lang="en">

<?php 
session_start();
include "includes/header.php"; 
include "includes/login_modal.php";
include "includes/signup_modal.php";
require("includes/database_connect.php");
$property_name = $_GET["property_name"];
$city_id = $_GET["city_id"];
$sql = "SELECT name FROM cities WHERE id='$city_id'";
$result = mysqli_query($conn, $sql);
if(!$result){
    echo "An error occured";
    exit;
}
$name = mysqli_fetch_assoc($result);
$city_name = $name["name"];

$sql = "SELECT * FROM properties WHERE name='$property_name'";
$result = mysqli_query($conn, $sql);
if(!$result){
    echo "An error occured";
    exit;
}
$properties = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach($properties as $property){
    $property_image = glob("img/properties/".$property["id"]."/*");
}
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
$id = $property["id"];
$sql = "SELECT * FROM testimonials WHERE property_id = '$id'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "An error occured";
    exit;
}
$testimonials = mysqli_fetch_assoc($result);
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT * FROM interested_users_properties up INNER JOIN properties p ON up.property_id = p.id WHERE up.user_id = '$user_id'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        echo "An error occured";
        exit;
    }
}
$prop_id = $property["id"];
$sql = "SELECT * FROM amenities_properties ap INNER JOIN amenities a ON ap.amenities_id = a.id WHERE ap.properties_id = '$prop_id'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "An error occured";
    exit;
}
$amenities = mysqli_fetch_all($result, MYSQLI_ASSOC);
$sql = "SELECT * FROM interested_users_properties iup INNER JOIN properties p ON iup.property_id = p.id WHERE p.name = '$property_name'"; 
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "An error occured";
    exit;
}
$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
$interested_users = count($data);
$sql3 = "SELECT * FROM interested_users_properties iup INNER JOIN properties p ON iup.property_id = p.id WHERE p.city_id = '$city_id'";
$result = mysqli_query($conn, $sql3);
if(!$result){
    echo "An error occured.";
    exit;
}
$interested_properties = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $_GET["property_name"] ?> | PG Life</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/property_detail.css" rel="stylesheet" />
</head>

<body>
    <div id="loading">
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="property_list.php?city=<?=$city_name?>"><?=$city_name?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= $property_name ?>
            </li>
        </ol>
    </nav>
    <?php
        $rating_clean = $property["rating_clean"];
        $rating_food = $property["rating_food"];
        $rating_safe = $property["rating_safe"];
    ?>
    <div id="property-images" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#property-images" data-slide-to="0" class="active"></li>
            <li data-target="#property-images" data-slide-to="1" class=""></li>
            <li data-target="#property-images" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src=<?= $property_image[0] ?> alt="slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src=<?= $property_image[1] ?> alt="slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src=<?= $property_image[2] ?> alt="slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="property-summary page-container">
        <div class="row no-gutters justify-content-between">
            <div class="star-container" title="4.8">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <div class="interested-container">
                <?php
                    $interested = false;
                    if(isset($_SESSION["user_id"])){
                        foreach ($interested_properties as $interested_property){
                                if($interested_property["user_id"] == $user_id && $interested_property["property_id"] == $prop_id){
                                    $interested = true;
                                }
                            }
                    }
                    if($interested){
                ?>
                <i class="is-interested-image fas fa-heart"></i>
                <?php 
                    }
                    else{
                ?>        
                <i class="is-interested-image far fa-heart"></i>
                <?php
                    }
                ?>
                <div class="interested-text">
                    <span class="interested-user-count"><?= $interested_users ?></span> interested
                </div>
            </div>
        </div>
        <div class="detail-container">
            <div class="property-name"><?= $property_name ?></div>
            <div class="property-address"><?= $property["address"] ?></div>
            <div class="property-gender">
                <img src=<?= male_female($property["gender"]) ?> />
            </div>
        </div>
        <div class="row no-gutters">
            <div class="rent-container col-6">
                <div class="rent"><?= $property["rent"] ?></div>
                <div class="rent-unit">per month</div>
            </div>
            <div class="button-container col-6">
                <a href="#" class="btn btn-primary">Book Now</a>
            </div>
        </div>
    </div>

    <div class="property-amenities">
        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <h5>Building</h5>
                    <?php
                        foreach ($amenities as $amenity) {
                            if($amenity["type"] == "Building"){ ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity["icon"] ?>.svg">
                                <span><?=$amenity["name"]?></span>
                            </div>
                            <?php
                            }
                        }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Common Area</h5>
                    <?php
                        foreach ($amenities as $amenity) {
                            if($amenity["type"] == "Common Area"){ ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity["icon"] ?>.svg">
                                <span><?=$amenity["name"]?></span>
                            </div>
                            <?php
                            }
                        }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Bedroom</h5>
                    <?php
                        foreach ($amenities as $amenity) {
                            if($amenity["type"] == "Bedroom"){ ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity["icon"] ?>.svg">
                                <span><?=$amenity["name"]?></span>
                            </div>
                            <?php
                            }
                        }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Washroom</h5>
                    <?php
                        foreach ($amenities as $amenity) {
                            if($amenity["type"] == "Washroom"){ ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity["icon"] ?>.svg">
                                <span><?=$amenity["name"]?></span>
                            </div>
                            <?php
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Property</h1>
        <p><?= $property["description"] ?></p>
    </div>

    <div class="property-rating">
        <div class="page-container">
            <h1>Property Rating</h1>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-broom"></i>
                            <span class="rating-criteria-text">Cleanliness</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $rating_clean ?>">
                        <?php for ($i = 0; $i < 5; $i++) {
                                if ($rating_clean >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating_clean >= $i + 0.3) {
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
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-utensils"></i>
                            <span class="rating-criteria-text">Food Quality</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" <?=$rating_food?>>
                        <?php for ($i = 0; $i < 5; $i++) {
                                if ($rating_food >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating_food >= $i + 0.3) {
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
                    </div>
                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fa fa-lock"></i>
                            <span class="rating-criteria-text">Safety</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title=<?=$rating_safe?>>
                        <?php   for ($i = 0; $i < 5; $i++) {
                                if ($rating_safe >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating_safe >= $i + 0.3) {
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
                    </div>
                </div>
                <?php 
                      $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safe']) / 3;
                      $total_rating = round($total_rating, 1); 
                ?>
                <div class="col-md-4">
                    <div class="rating-circle">
                        <div class="total-rating"><?= $total_rating ?></div>
                        <div class="rating-circle-star-container">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="property-testimonials page-container">
        <h1>What people say</h1>
        <div class="testimonial-block">
            <div class="testimonial-image-container">
                <img class="testimonial-img" src="img/man.png">
            </div>
            <div class="testimonial-text">
                <i class="fa fa-quote-left" aria-hidden="true"></i>
                <p><?= $testimonials["content"] ?></p>
            </div>
            <div class="testimonial-name">- <?= $testimonials["user_name"] ?></div>
        </div>
    </div>

    <div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signup-heading" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signup-heading">Signup with PGLife</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="signup-form" class="form" role="form">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="full_name" placeholder="Full Name" maxlength="30" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-phone-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number" maxlength="10" minlength="10" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" minlength="6" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-university"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="college_name" placeholder="College Name" maxlength="150" required>
                        </div>

                        <div class="form-group">
                            <span>I'm a</span>
                            <input type="radio" class="ml-3" id="gender-male" name="gender" value="male" /> Male
                            <label for="gender-male">
                            </label>
                            <input type="radio" class="ml-3" id="gender-female" name="gender" value="female" />
                            <label for="gender-female">
                                Female
                            </label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Create Account</button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <span>Already have an account?
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#login-modal">Login</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-heading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="login-heading">Login with PGLife</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="login-form" class="form" role="form">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" minlength="6" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Login</button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <span>
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#signup-modal">Click here</a>
                        to register a new account
                    </span>
                </div>
            </div>
        </div>
    </div>

<?php
include "includes/footer.php";
?>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="js/common.js"></script>
    <script src="js/property_detail.js"></script>
</body>

</html>
