<?php  
session_start();
include('../includes/header.php');
include('../config/dbconfig.php');
?>
<link rel="stylesheet" text=" text/css" href="../css/account.css">

<container>
    <h1 class = "account-title">Reset Your Password</h1>
    <form class = "acc-log" id='form' action='../php/account_update.php' method='post' enctype='multipart/form-data'>
        <div>
            <label>Email:</label>
            <input type='text' name='emailCheck' id='emailCheck'>
        </div>

        <div>
            <label>New Password:</label>
            <input type='text' name='ResetPassword' id='ResetPassword'>
            <div class='error'><small></small></div>
        </div>

        <div>
            <label>Retype New Password:</label>
            <input type='text' name='RetypePassword' id='RetypePassword'>
            <div class='error'><small></small></div>
        </div>

        <button class ="submit" type='submit' name='reset'>Reset Password</button>
    </form>
</container>

<?php include('../includes/footer.php'); ?>