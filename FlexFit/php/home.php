<?php
session_start();
include('../includes/header.php');
include('functions.php');
include('../config/dbconfig.php');
$feature_products = getFeaturedProducts($pdo, "products");
?>

<?php
/*
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
*/
?>
<link rel="stylesheet" text=" text/css" href="../css/homeabout.css">

<div id="cookie-consent-popup" class="cookie-popup">
    <p>This website uses cookies to ensure you get the best experience on our website.</p>
    <button id="accept-cookies">Accept</button>
</div>


<!-- Hero Section -->
<div class="hero-container">
    <div class="slider">

        <input type="radio" class="radio" name="images" id="radio-1" checked>
        <input type="radio" class="radio" name="images" id="radio-2">
        <input type="radio" class="radio" name="images" id="radio-3">

        <div class="slide" id="slide-1">
            <div class="hero">
                <h1>Train With FlexFit</h1>
                <p>Begin your fitness adventures with FLEXFIT</p>
                <a href='shop.php'> <button>Shop Now</button> </a>
            </div>
        </div>

        <div class="slide" id="slide-2">
            <div class="hero-2">
                <h1>Join Our Membership</h1>
                <p>We Offer you endless possibilities</p>
                <a href='membership.php'> <button>Sign Up Now</button> </a>
            </div>
        </div>

        <div class="slide" id="slide-3">
            <div class="hero-3">
                <h1>FlexFit Locations</h1>
                <p>We are all around you</p>
                <a href='contact.php'> <button>Find Us</button> </a>
            </div>
        </div>

        <div class="bar">
            <label for="radio-1" id="label-1" class="label active"></label>
            <label for="radio-2" id="label-2" class="label"></label>
            <label for="radio-3" id="label-3" class="label"></label>
        </div>

    </div>
</div>

<!-- Best Seller from database -->
<div class="bestsellers">
    <h1>Featured Products</h1>
    <div class="product-container">
        <?php
        $featuredProducts = getFeaturedProducts($pdo, "product");
        foreach ($featuredProducts as $row) {
            // Extract information from the database row
            $productName = $row['productName'];
            $description = $row['productDescription'];
            $price = $row['Price'];
            $image = $row['ImageName'];

            // Generate HTML for each featured product
            echo "<div class='product'>";
            echo "<div class='product-img'><img src='../images/products/$image'></div>";
            echo "<h2>$productName</h2>";
            echo "<p class='price'>$" . number_format($price, 2) . "</p>";
            echo "<button>Buy Now</button>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<!-- About Us -->
<div class="about">
    <img src="../images/Home/Main/homeimg1.jpg">

    <div>
        <h1>About Us</h1>
        <p>
            Here at Flexfit, we offer you the opportunity to embark on a healthier and more athletic lifestyle,
            delivered through the proper guidance of our team to ensure that you adjust within our community, and
            promote a better well-being together. Additionally, we offer a diverse range of products and equipment
            for those who are interested in upping their game, and reaching new heights.
        </p>

        <marquee loop="-1" scrollamount="10" width="100%"> Begin your Fitness Journey</marquee>
    </div>
</div>

<!-- We offer -->
<!-- images from manypixels.co-->
<div class="features">
    <h1>We Offer</h1>

    <div class="features-container">
        <div class="card">
            <div class='feature-img image1'> </div>
            <h2>Fast Delivery</h2>
        </div>

        <div class="card">
            <div class='feature-img image2'> </div>
            <h2>Online Purchases</h2>
        </div>

        <div class="card">
            <div class='feature-img image3'> </div>
            <h2>24/7 Support</h2>
        </div>
    </div>

    <div class="features-container">
        <div class="card">
            <div class='feature-img image4'> </div>
            <h2>Cheap Prices</h2>
        </div>

        <div class="card">
            <div class='feature-img image5'> </div>
            <h2>Quality Products</h2>
        </div>
    </div>
</div>

<!-- BMI Calculator code -->

<script src="../assets/js/bmicalculator.js"></script>

<div>
    <div class="bmi-container">
        <div class="calculator">
            <h1>BMI Calculator</h1>

            <p>Height (cm)</p>
            <input type="number" id="height">

            <p>Weight (kg)</p>
            <input type="number" id="weight">

            <button id="button">Calculate</button>

            <div id="result">Result</div>

        </div>

    </div>

</div>


<?php
// Check if the user has already accepted cookies
if (!isset($_COOKIE['cookies_accepted'])) {
    echo '<div id="cookie-consent-popup" class="cookie-popup">
              <p>This website uses cookies to ensure you get the best experience on our website.</p>
              <button id="accept-cookies">Accept</button>
          </div>';
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cookiePopup = document.getElementById("cookie-consent-popup");
        const acceptCookiesButton = document.getElementById("accept-cookies");

        // Event listener for accepting cookies
        acceptCookiesButton.addEventListener("click", function() {
            // Hide the popup
            cookiePopup.style.display = "none";

            // Set a cookie to store user's consent
            document.cookie = "cookies_accepted=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
        });
    });
</script>


<!-- Stay Up to Date Email 
<div class="news">
    <div class="text">
        <h1>Stay Up to Date</h1>
        <p>Sign up and recieve emails about our <span>latest discounts</span> and <span>special offers</span></p>
    </div>

    <div class="form">
        <input type="text" placeholder="Email Address" />
        <button> Sign Up </button>
    </div>
</div> -->

<script src="../assets/js/homeimgslider.js"> </script>

<?php include('../includes/footer.php'); ?>