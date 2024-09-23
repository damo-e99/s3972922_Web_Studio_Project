<?php
session_start();
include('../includes/header.php');
include('../php/functions.php');


// if (isset($_SESSION['message'])) {
//     echo $_SESSION['message'];
// }else{
//     unset($_SESSION['message']);
// }

?>
<link rel="stylesheet" text=" text/css" href="../css/account.css">

<style>
    #result {
        color: red;
    }
</style>


<container>
    <h1 class = "account-title">Login</h1>
    <form class = "acc-log" action='../php/functions.php' method='POST'>
        <!-- DDisplay restriction based messages -->
        <div id='result'><?php echo $_SESSION['message']; ?></div>
        <div>
            <label for='email'>User Email Address</label>
            <input type='email' name='email' placeholder="Enter Email Address">
        </div>
        <div>
            <label for='password'>User Password</label>
            <input type='password' name='pass' placeholder="Enter Password">
        </div>
        <button class ="submit" type='submit' name='submit'>Login</button>
    </form>
    <button class = "reset" onclick="window.location.href = '../php/resetPass.php';">Reset Password</button>
</container>

<?php include('../includes/footer.php') ?>