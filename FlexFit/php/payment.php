<!-- Navbar-->
<?php session_start(); ?>
<?php include('../includes/header.php') ?>
<link rel="stylesheet" text=" text/css" href="../css/payment.css">
<!-- Payment Content-->

<div id='Payment-bill'>
    <form id="payment_form" onsubmit="return checkForm()" method="post" action="complete.php">
    >
        <h1>FlexFit CheckOut</h1>

     
        <div class='pay-type'>
            <p>Visa</p>
            <p>Master Card</p>
            <p>Paypal</p>
        </div>

        <!-- Billing Address-->
        <h2>Billing Address</h2>

        <div>
            <label'>First Name</label>
            <input name='firstName' id='firstName' type='text' placeholder='Your First Name'>
            <div class='error'><small></small></div>
        </div>

        <div>
            <label>Last Name</label>
            <input name='lastName' id='lastName' type='text' placeholder='Your Last Name'>
            <div class='error'><small></small></div>
        </div>

        <div>
            <label>Street</label>
            <input name='streetName' id='streetName' type='text' placeholder='13 Swanstan Street'>
            <div class='error'><small></small></div>
        </div>

        <div>
            <label>City</label>
            <input name='cityName' id='cityName' type='text' placeholder='Melbourne'>
            <div class='error'><small></small></div>
        </div>

        <div>
            <label>State</label>
            <input name='stateName' id='stateName' type='text' placeholder='VIC'>
            <div class='error'><small></small></div>
        </div>

        <div>
            <label>Zip</label>
            <input name='zipCode' id='zipCode' type='text' placeholder='3174'>
            <div class='error'><small></small></div>
        </div>

        <label>
            <label>Shipping address same as billing</label>
            <input type="checkbox" checked="checked" name="sameAddy">
            <div class='error'><small></small></div>
        </label>

         <!-- Payment Informoration-->
        <h2>Card Info</h2>

            <div>
                <label>Name on Card</label>
                <input name='cardName' id='cardName' type='text' placeholder='Card Name'>
                <div class='error'><small></small></div>
            </div>

            <div>
                <label>Card Number</label>
                <input name='cardNum' id='cardNum' type='text' placeholder='1111-2222-3333-4444'>
                <div class='error'><small></small></div>
            </div>

            <div class='date-list'>
                <label>Expiration Month</label>
                    <select id='expMonth'>
                        <option value='01'>Jan</option>
                        <option value='02'>Feb</option>
                        <option value='03'>March</option>
                        <option value='04'>April</option>
                        <option value='05'>May</option>
                        <option value='06'>June</option>
                        <option value='07'>July</option>
                        <option value='08'>Aug</option>
                        <option value='09'>Sept</option>
                        <option value='10'>Oct</option>
                        <option value='11'>Nov</option>
                        <option value='12'>Dec</option>
                    </select>
                    <div class='error'><small></small></div>
            </div>

            <div class='date-list'>
                <label >Exp Year</label>
                    <select id='expYear'>
                        <option value='2023'>2023</option>
                        <option value='2023'>2022</option>
                        <option value='2023'>2021</option>
                        <option value='2023'>2020</option>
                        <option value='2023'>2019</option>
                    </select>
                    <div class='error'><small></small></div>
            </div>

            <div>
                <label>CCV</label>
                <input name='ccvNum' id='ccvNum' type='text' placeholder='3 diits on the back of the card'>
                <div class='error'><small></small></div>
            </div>
            
        <div>
            <input id="complete_order" type="submit" value="Complete Your Order" />
        </div>
            
    </form>
</div>

<script src="../assets/js/paymentVal.js" defer></script>

<!-- Page Footer-->
<?php include('../includes/footer.php') ?>