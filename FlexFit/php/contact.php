<?php
session_start();
include('../includes/header.php');
include('../config/dbconfig.php');
include('../php/functions.php');
?>
<link rel="stylesheet" text=" text/css" href="../css/contact.css">

<head>    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" text=" text/css" href="../css/contactMap.css">
</head>

<!-- Banner -->
<div class="banner-contact">
    <h2>#Contact Us</h2>
    <p>Let us help you</p>
</div>

<!-- Contact Details -->
<div class="contact-det">
    <div class="details">
        <h1>Get In Contact With Us</h1>

        <li> <img src="../images/Contact/map-outline.png"> RMIT University, Melbourne City </li>
        <li> <img src="../images/Contact/email-outline.png"> FlexFit@gmail.com </li>
        <li> <img src="../images/Contact/phone-outline.png"> 1800 483 192 </li>
        <li> <img src="../images/Contact/clock-outline.png"> Monday to Sunday 8am to 5pm </li>

    </div>

    <!-- Displays Geolocation Map -->
    <div id="map" name="map"></div>
    <div id="msg"></div>
    
    <script src="../assets/js/geolocationAPI.js" defer></script>

</div>

<script src="../assets/js/contactValidation.js"> </script>

<!-- Contact Form -->
<div class="contact-form">
    
    <!-- contact form -->
    <form id="contact_form" onsubmit="return checkForm()" method="post" action="contact.php">
        <h2>Email Us</h2>
        <div>
            <span class="label">Your name:</span>
            <input name="fullname" type="text" value="" id="fullname" placeholder="Full name" />
        </div>
        <div class="error" id="fullnameError">Required: This field is Required</div>

        <div>
            <span class="label">Your email address:</span>
            <input name="email" type="text" value="" id="email" placeholder="example@example.com" />
        </div>
        <div class="error" id="emailError"> Required: This field is Required</div>

        <div>
            <span class="label">Your message:</span>
            <input name="message" type="textarea" col="30" rows="40" value="" id="message" placeholder="Enter You Message"> </input>
        </div>
        <div class="error" id="messsageError"> Required: This field is Required</div>

        <div><input id="send_message" type="submit" value="Send message" /></div>
    </form>
</div>

<!-- News 
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

<!-- Page Footer-->
<?php include('../includes/footer.php') ?>