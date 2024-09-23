<?php
session_start();
include('../includes/header.php');
include('../php/functions.php');
include('../config/dbconfig.php');



$users = getAllUsers($pdo, "users", $user);



if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $user = getUserDetails($pdo, "users", $user_id);

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newUsername = $_POST['username'];
            $newFirstName = $_POST['fname'];
            $newLastName = $_POST['lname'];
            $newEmail = $_POST['email'];
            $newPassword = $_POST['pass'];
            $newPhoneNumber = $_POST['phnumber'];
            $newUserRole = $_POST['role'];
            $newMembershipLevel = $_POST['membership'];
            $newProfileImage = $_POST['profileImage'];
            $newActiveStatus = $_POST['active'];

            $sql = "UPDATE users SET 
                username = :username,
                fname = :fname,
                lname = :lname,
                email = :email,
                pass = :pass,
                phnumber = :phnumber,
                role = :role,
                membership = :membership,
                profileImage = :profileImage,
                active = :active
                WHERE id = :user_id";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':fname', $newFirstName);
            $stmt->bindParam(':lname', $newLastName);
            $stmt->bindParam(':email', $newEmail);
            $stmt->bindParam(':pass', $newPassword);
            $stmt->bindParam(':phnumber', $newPhoneNumber);
            $stmt->bindParam(':role', $newUserRole);
            $stmt->bindParam(':membership', $newMembershipLevel);
            $stmt->bindParam(':profileImage', $newProfileImage);
            $stmt->bindParam(':active', $newActiveStatus);
            $stmt->bindParam(':user_id', $user_id);

            if ($stmt->execute()) {
                header("Location: ../admin/manage_users.php");
                exit;
            } else {
                echo "Error updating user in the database.";
            }
        }
?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?= $user['username'] ?>">

            <label for="fname">First Name:</label>
            <input type="text" name="fname" value="<?= $user['fname'] ?>">

            <label for="lname">Last Name:</label>
            <input type="text" name="lname" value="<?= $user['lname'] ?>">

            <label for="email">Email:</label>
            <input type="text" name="email" value="<?= $user['email'] ?>">

            <label for="pass">Password:</label>
            <input type="text" name="pass" value="<?= $user['pass'] ?>">

            <label for="phnumber">Phone Number:</label>
            <input type="text" name="phnumber" value="<?= $user['phnumber'] ?>">

            <label for="role">User Role:</label>
            <select name="role">
                <option value="1" <?php if ($userToEdit['role'] == 1) echo ''; ?>>Admin</option>
                <option value="0" <?php if ($userToEdit['role'] == 0) echo ''; ?>>Customer</option>
            </select>

            <label for="membership">Membership:</label>
            <select name="membership">
                <option value="" <?php if (empty($userToEdit['membership']))?>>Free</option>
                <option value="bronze" <?php if ($userToEdit['membership'] === 'bronze') ?>>Bronze</option>
                <option value="silver" <?php if ($userToEdit['membership'] === 'silver') ?>>Silver</option>
                <option value="gold" <?php if ($userToEdit['membership'] === 'gold')?>>Gold</option>
            </select>

            <label for="active">Active Status:</label>
            <select name="active">
                <option value="1" <?php if ($userToEdit['active'] == 1) echo ''; ?>>Active</option>
                <option value="0" <?php if ($userToEdit['active'] == 0) echo ''; ?>>Not Active</option>
            </select>

            <input type="submit" value="Save Changes">
        </form>
<?php
    }
}
?>

<!-- Linking CSS-->
<link rel="stylesheet" text=" text/css" href="../css/admin.css">

<div class = "admin-table">
    <table class="modifyusers">
        <tr class = "user-head">
            <th>ID</th>
            <th>username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Phone Number</th>
            <th>Date Created</th>
            <th>User Role</th>
            <th>Membership Level</th>
            <th>Profile Image</th>
            <th>Active Status</th>
            <th></th>
        </tr>
        <?php
        if ($users) {
            foreach ($users as $user) {
        ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['fname'] ?></td>
                    <td><?= $user['lname'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['pass'] ?></td>
                    <td><?= $user['phnumber'] ?></td>
                    <td><?= $user['created'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?= $user['membership'] ?></td>
                    <td><?= $user['profileImage'] ?></td>
                    <td><?= $user['active'] ?></td>
                    <td>
                        <a href="?user_id=<?= $user['id'] ?>">Edit</a>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<p class='text-center'>No products available</p>";
        }
        ?>
    </table>
</div>

<?php
include('../includes/footer.php');
?>