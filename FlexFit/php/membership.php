<?php
    session_start();
    include('../config/dbconfig.php');
    include('../includes/header.php');
    include('functions.php');

    //Create PDO connection with shared DB
    $dsn = 'mysql:host=talsprddb02.int.its.rmit.edu.au;dbname=COSC3046_2302_G4';
    $user = 'COSC3046_2302_G4';
    $pass = '6s8J0bplE7D6';
    
    try
    {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo 'Connection has failed: ' . $e->getMessage();
    }

    //fetch all data from membership table
    $membership = getAllMembership($conn, "membershipLevel");
    //fetch benefits for each level of memberships (most used)
    $bronzeLevel = getBenefitsMemberLevel($conn, "membershipLevel", "Bronze");
    $silverLevel = getBenefitsMemberLevel($conn, "membershipLevel", "Silver");
    $goldLevel = getBenefitsMemberLevel($conn, "membershipLevel", "Gold");

?>

<link rel="stylesheet" text=" text/css" href="../css/membership.css">

<!-- Banner -->
<div class="banner-member">
    <img src="../images/Membership/membershipbanner.jpg" alt="Banner Image" />
</div>

<div class="memberships">
    <h1>Memberships</h1>
    <div class="membership-container">
        <div class="bronze">
            <?php
                //only loads if there is data
                if (!empty($bronzeLevel)) {
                    //fetch the TYPE from DB
                    $bronzeLevelName = $bronzeLevel[0]['MEMBER_TYPE'];
                    echo "<h2>$bronzeLevelName</h2>";

                    //loop benefits
                    foreach ($bronzeLevel as $benefits) {
                        $benefitList = explode(', ', $benefits['MEMBER_DESCRIPTION']);
                        foreach ($benefitList as $benefit) {
                            echo '<li>'.$benefit.'</li>';
                        }
                    }

                    //fetch price
                    foreach ($bronzeLevel as $price) {
                        echo '<p class="price">$' . $price['MEMBER_PRICE'] . '.00</p>';
                    }
                }
            ?>
            <button><a href="../php/registration.php"> Sign Up </a></button>
        </div>

    <div class="membership-container">
        <div class="silver">
            <?php
                if (!empty($silverLevel)) {
                    //fetch TYPE
                    $silverLevelName = $silverLevel[0]['MEMBER_TYPE'];
                    echo "<h2>$silverLevelName</h2>";

                    foreach ($silverLevel as $benefits) {
                        $benefitList = explode(', ', $benefits['MEMBER_DESCRIPTION']);
                        foreach($benefitList as $benefit) {
                            echo '<li>'.$benefit.'</li>';
                        }
                    }

                    //fetch price
                    foreach($silverLevel as $price) {
                        echo '<p class="price">$'.$price['MEMBER_PRICE'].'.00</p>';
                    }
                }   
            ?>
            <button><a href="../php/registration.php"> Sign Up </a></button>
        </div>

    <div class="membership-container">
        <div class="gold">
            <?php
                if (!empty($goldLevel)) {
                    //fetch TYPE
                    $goldLevelName = $goldLevel[0]['MEMBER_TYPE'];
                    echo "<h2>$goldLevelName</h2>";

                    foreach ($goldLevel as $benefits) {
                        $benefitList = explode(', ', $benefits['MEMBER_DESCRIPTION']);
                        foreach ($benefitList as $benefit) {
                            echo '<li>'.$benefit.'</li>';
                        }
                    }

                    foreach($goldLevel as $price) {
                        echo '<p class="price">$'.$price['MEMBER_PRICE'].'.00</p>';
                    }
                }
            ?>
            <button><a href="../php/registration.php"> Sign Up </a></button>
        </div>
            
    </div>
    </div>
    </div>


</div>


<?php include('../includes/footer.php') ?>