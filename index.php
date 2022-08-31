<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    include "includes/head_links.php";
    include "includes/header.php";
    include "includes/signup_modal.php"; 
    include "includes/login_modal.php";
  ?>
  <title>Welcome|PG Life</title>
</head>

<body>
  <div id="loading">
  </div>
  <div class="banner-container">
    <img src="img/bg.png" alt="" class="imgIndex">
    <div class="sub-div">
      <p class="h2">Happiness per Square Foot</p>
      <div class="container-fluid">
        <form class="d-flex" action="property_list.php" method="get">
          <input class="form-control me-2" type="search" placeholder="Enter your city to search for PGs" aria-label="Search" name="city">
          <button class="btn btn-secondary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg></button>
        </form>
      </div>
    </div>
  </div>
  <div class="cities-div">
    <p class="h1" id="headline">Major Cities</p>
    <a href="property_list.php?city=Delhi" class="cities"><img src="img/delhi.png" alt="" style="width: 130px;box-shadow:4px 4px 8px rgb(47, 46, 46);"></a>
    <a href="property_list.php?city=Mumbai" class="cities"><img src="img/mumbai.png" alt="" style="width: 130px;box-shadow:4px 4px 8px rgb(47, 46, 46);"></a>
    <a href="property_list.php?city=Bengaluru" class="cities"><img src="img/bangalore.png" alt="" style="width: 130px;box-shadow:4px 4px 8px rgb(47, 46, 46);"></a>
    <a href="property_list.php?city=Hyderabad" class="cities"><img src="img/hyderabad.png" alt="" style="width: 130px;box-shadow:4px 4px 8px rgb(47, 46, 46);"></a>
  </div>
  <?php include "includes/footer.php";?>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script src="js/common.js"></script>
</body>
</html>