<?php
session_start();
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


//Check if the user has wanted to change password ON THE ACCOUNT MANAGEMENT PAGE !!!
if (isset($_POST['updatePass'])) {
    //get user current ID based on session
    $user_id = $_SESSION['authenticated_user']['id'];

    //get values for password
    $current_pass = $_POST['pass'];
    $new_pass = $_POST['newPass'];
    $update_pass = $_POST['newPassConfirm'];

    //ensure password will be securely stored in DB
    // $hash_pass = password_hash($new_pass, PASSWORD_DEFAULT);

    //update query using the hash
    $update_query = 'UPDATE users SET pass = :new_pass WHERE id = :id';
    try {
        $stmt = $conn->prepare($update_query);
        $stmt->bindParam(':new_pass', $new_pass);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Password has been successfully changed!');window.location.href='account.php'</script>";
        
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


if (isset($_POST['updateProfile'])) {
    //get user current ID based on session
    $user_id = $_SESSION['authenticated_user']['id'];

    //get values for fname, lname, email
    $userFirstN = $_POST['fname'];
    $userLastN = $_POST['lname'];
    $userEmail = $_POST['email'];

    //Statement used to store membership values
    if (isset($_POST['membership'])) {
        $membership = $_POST['membership'];
        $query = 'UPDATE users SET membership = :membership WHERE id = :user_id';

        $stmt = $conn->prepare($query);
        $stmt->bindparam(':membership', $membership);
        $stmt->bindparam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //query
    $profile_query = 'UPDATE users SET fname = :fname, lname = :lname, email = :email WHERE id = :id';

    try {
        //call variable to update sql query and table
        $stmt = $conn->prepare($profile_query);
        $stmt->bindparam(':fname', $userFirstN);
        $stmt->bindparam(':lname', $userLastN);
        $stmt->bindparam(':email', $userEmail);
        $stmt->bindparam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Profile information successfully changed!');window.location.href='account.php'</script>";

    }catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


//Hash comparison
function resetPassword($conn, $email, $password) {
    $checkEmailQuery = 'SELECT id from users WHERE email = :emailCheck';
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bindParam(":emailCheck", $email);
    $stmt->execute();

    try {
        if ($stmt->rowCount() > 0) {
            //Check if email is in the database
            $updatePassQuery = 'UPDATE users SET pass = :hash_pass WHERE email = :email';
            $stmt = $conn->prepare($updatePassQuery);

            $hash_pass = password_hash($password, PASSWORD_BCRYPT);

            $stmt->bindParam(":hash_pass", $hash_pass);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            //password success
            return true;
        } else {
            //email not found
            return false;
        }
    } catch (PDOException $e) {
        return false;
        echo 'Error: ' . $e->getMessage();
    }
}

//Reset Password Page for users who cannot log into their account. NOT ACCOUNT LOGIN PAGE !!! 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {

    $email = $_POST['emailCheck'];
    $new_pass = $_POST['ResetPassword'];
    $update_pass = $_POST['RetypePassword'];

    if ($new_pass === $update_pass) {
        $result = resetPassword($conn, $email, $new_pass);

        if ($result === true) {
            echo "<script>alert('Password Successfully Reset');window.location=href='login.php'</script>";
        } else if ($result === false) {
            echo "<script>alert('Not an Existing Email');</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match');</script>";
    }
}

//Handles uploading a user profile
if (isset($_POST['Upload'])) {
    //allowed image types
    $file_info = new finfo(FILEINFO_MIME_TYPE);
    $img_types = ["image/png", "image/jpeg", "image/jpg", "image/gif"];

    //get directory of current folder, uploadfolder, and filename
    $fileLocation = __DIR__ . "/Account/";

    $img_type = $file_info->file($_FILES["image"]["tmp_name"]);
    $filename = $_FILES["image"]["name"];

    if (isset($_FILES['image'])) {
        $img_type = $file_info->file($_FILES["image"]["tmp_name"]);
        $filename = $_FILES["image"]["name"];
        echo "hi, image is set";
    } else {
        echo "Upload an image";
    }

    //check if post method is used, otherwise exit script
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit("Post method is required");
    }

    if (empty($_FILES)) {
        exit('$_FILES is empty');
    }

    //check if file upload error is not ok
    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {

    //exit error switch
    switch ($_FILES["image"]["error"]) {
        //checks the state of the file and returning exit messages based on the upload error
        case UPLOAD_ERR_PARTIAL:
            exit("File only partially uploaed");
            break;
        case UPLOAD_ERR_NO_FILE:
            exit("No file was uploaded");
            break;
        case UPLOAD_ERR_EXTENSION:
            exit("File upload stopped by a PHP extension");
            break;
        case UPLOAD_ERR_INI_SIZE:
            exit("File exceeds the max upload size");
            break;
        //ensure any errors which arent found return atleast an error message for debugging
        default:
            exit("Unkown file uploaded causing error");
            break;
        }
    }

    //check if file size is too big
    if ($_FILES["image"]["size"] > 10000000) {
        exit("File is too large (Exceeds 10MB)");
    }

    //within the uploaded array, check file type
    if (!in_array($_FILES["image"]["type"], $img_types)) {
        exit("Invalid file type");
    }

    //check if uploaded file can be moved to new directory
    $destinationPath = $fileLocation . $filename;
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $destinationPath)) {
        exit("Cannot move uploaded file to new directory");
    }

    echo "<pre>";
    print_r($_FILES);
    var_dump($_FILES);
    echo "</pre>";

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $user_id = $_SESSION['authenticated_user']['id'];

        $query = 'UPDATE users SET profileImage = :image_name WHERE id = :user_id';
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam('image_name', $filename);
            $stmt->execute();

            echo "<script>alert('Profile Set');window.location.href='account.php'</script>";
            $_SESSION['authenticated_user']['profileImg'] = $filename;

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * FIXES
     * 
     * 1: file permission 0777 for the Account images folder in php, which allows uploads
     *    -> chmod 0777 Account/
     * 
     * 2: while checking if the file can move to new DIR (last if statement), had to include the filename ($filename)
     */
}
?>