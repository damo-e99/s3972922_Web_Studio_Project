<?php
session_start();
include('../includes/header.php');

?>
<link rel="stylesheet" text=" text/css" href="../css/account.css">

<!-- Error message not working as intended. -->
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Oh no!</strong> <?= $_SESSION['message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['message']);
}
?>

<container>
    <h1 class = "account-title">Register</h1>
    <form class = "acc-log" action='../php/functions.php' method='POST' id='form'>
        <div class = "reg-name">
            <div class="content-container">
                <label for='fname'>First Name</label>
                <input class = "name" type='text' name='fname' id='fname' placeholder="Enter First Name">
                <div class='error'><small></small></div>
            </div>
            
            <div class="content-container">
                <label for='lname'>Last Name</label>
                <input class = "name" type='text' name='lname' id='lname' placeholder="Enter Last Name">
                <div class='error'><small></small></div>
            </div>
        </div>

        <div class="content-container">
            <label for='email'>User Email Address</label>
            <input type='email' name='email' id='email' placeholder="Enter Email Address">
            <div class='error'><small></small></div>
        </div>
        <div class="content-container">
            <label for='password'>User Password</label>
            <input type='password' name='pass' id='password' placeholder="Enter Password">
            <div class='error'><small></small></div>
        </div>
        <div class="content-container">
            <label>Confirm Password</label>
            <input type='password' name='confirm_pass' id='confirm_pass' placeholder="Confirm Password">
            <div class='error'><small></small></div>
        </div>
        <div class="content-container">
            <label for='phnumber'>Stay Up To Date: Enter Phone Number</label>
            <input type='phnumber' name='phnumber' id='phnumber' placeholder="Enter Phone Number">
            <div class='error'><small></small></div>
        </div>
        <button class ="submit" type='submit' name='register'>Create Account</button>
        <button class ="submit"> <a href='../php/login.php'>Login</a></button>
    </form>
</container>
<script type="text/javascript" src="../assets/js/accountValidation.js"></script>

<?php include('../includes/footer.php') ?>