<?php 
session_start();
include_once('../config/dbconfig.php');

if (isset($_POST['archive'])) {
    $user_id = $_SESSION['authenticated_user']['id'];
    $activeNum = 0;

    try {
        //Insert current user values into new archive table
        // $insertQuery = "INSERT INTO archiveUsers SELECT * FROM users WHERE id = :user_id";
        $insertQuery = "UPDATE users SET active = :active WHERE id = :user_id";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":active", $activeNum);
        $stmt->execute();

        echo "<script>alert('Account archived successfully');window.location.href='home.php'</script>";

        if(isset($_SESSION['authenticated_user'])){
            unset($_SESSION['authenticated']);
            unset($_SESSION['authenticated_user']);
            $_SESSION['message'] = "Logged Out";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e.getMessage();
    }   
} else {
    echo "<script>alert('Account archived UNsuccessfully');window.location.href='account.php'</script>";
}


?>