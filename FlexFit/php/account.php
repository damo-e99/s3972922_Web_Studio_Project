<!-- header -->
<?php session_start(); ?>
<?php include('../includes/header.php') ?>
<?php include('../config/dbconfig.php'); ?>
<?php include_once('../php/functions.php'); ?>
<link rel="stylesheet" text=" text/css" href="../css/account.css">

<div class='profile-container'>

<div class='block1'>
        <!-- User Profile image -->
        <h2 class='profile-head'>Profile Picture</h2>
        <div class='profile-image'>
            <form class="acc-edit" action="../php/account_update.php" method='post' enctype="multipart/form-data">
                <label for='image'>Profile Picture:</label>

                <!-- User Image Display -->
                <img src="../php/Account/<?= $_SESSION['authenticated_user']['profileImg'] ?>" alt="User profile image"> 
                

                <input type='file' name='image'>
                <input type='submit' name='Upload' value='Upload Image'>
            </form>
        </div>
    </div>

    <div class='block2'>
        <h2 class='profile-head'>Profile Overview</h2>
        <div class='profile-edit'>
            <form class="acc-edit"  action="../php/account_update.php" method='post'>
                <div class='profile-items'>
                    <label for='fname'>First Name:</label>
                    <input type='text' id='fname' name='fname'  value='<?php echo $_SESSION['authenticated_user']['fname']; ?>'>
                </div>

                <div class='profile-items'>
                    <label for='lname'>Last Name:</label>
                    <input type='text' id='lname' name='lname' value='<?php echo $_SESSION['authenticated_user']['lname']; ?>'>
                </div>

                <div class='profile-items'>
                    <label for='email'>Email:</label>
                    <input type='text' id='email' name='email' value='<?php echo $_SESSION['authenticated_user']['email']; ?>'>
                </div>

                <div class='profile-items'>
                    <label for='membership'>Membership:</label>
                    <select name='membership' id='membership'>
                        <option><?php echo $_SESSION['authenticated_user']['membership']; ?></option>
                        <option value='bronze'>Bronze</option>
                        <option value='silver'>Silver</option>
                        <option value='gold'>Gold</option>
                    </select>
                </div>

                <input type='submit' name='updateProfile' value='Save Changes'>
            </form>
        </div>
    </div>

    <div class='block3'>
        <h2 class='profile-head'>Edit Password</h2>
        <div class='profile-edit'>
            <form class="acc-edit" action="../php/account_update.php" method="post">
                <div class='profile-items'>
                    <label for='pass'>Password:</label>
                    <input type='text' id='pass' name='pass'>
                </div>

                <div class='profile-items'>
                    <label for='newPass'>New Password:</label>
                    <input type='text' id='newPass' name='newPass'>
                </div>

                <div class='profile-items'>
                    <label for='newPassConfirm'>Retype New Password:</label>
                    <input type='text' id='newPassConfirm' name='newPassConfirm'>
                </div>

                <input type='submit' name='updatePass' value='Change Password'>
            </form>
        </div>
    </div>

    <!-- This script handles user option for archive (yes/no) -->
    <script>
        function confirmArchiveAction() {
            if (confirm("Are you sure you want to archive the account?")) {
                return true;
            }else{
                return false;
            }
        }
    </script>

    <div class='block4'>
        <h2 class='profile-head'>Archive</h2>
        <div class='profile-edit'>   
            <form class="acc-edit" method="post" action="../php/archive.php" onsubmit="return confirmArchiveAction()"> 
                <div class='profile-items'>    
                    <label for='archive'>Archive Account:</label>
                </div>
                <input type='submit' name='archive' value="Archive">
            </form>
        </div> 

    </div>

</div>

<!-- footer -->
<?php include('../includes/footer.php') ?>