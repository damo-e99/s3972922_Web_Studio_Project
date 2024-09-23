<?php
session_start();
include('../includes/header.php');

if (isset($_SESSION['authenticated_user']) && $_SESSION['authenticated_user']['role'] == 1) {
?>

    <link rel="stylesheet" text=" text/css" href="../css/admin.css">

    <div class="admin-configs">
        <h1>Administration Configs</h1>

        <button> <a href="add_products.php">Add Products</a> </button>
        <button> <a href="modify_products.php">Alter Products</a> </button>
        <button> <a href="manage_users.php">Manage Users</a> </button>
        <button> <a href="forum_monitor.php">Forum Moderation</a> </button>
    </div>

<?php
} else {
    header('Location: ../php/home.php');
    exit;
}

include('../includes/footer.php');
?>