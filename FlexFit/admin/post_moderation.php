<?php
session_start();
include('../includes/header.php');
include('../config/dbconfig.php');
include("../php/forum_functions.php");
include("../admin/admin_forum_functions.php");
if (isset($_SESSION['authenticated_user']) && $_SESSION['authenticated_user']['role'] == 1) {
    $post_id = $_GET['post_id'];
    $comments = getAdminComments($pdo, "forumComments", $post_id);

?>

    <link rel="stylesheet" text=" text/css" href="../css/admin.css">
    <div class="forum-table">
        <table class="forum-styling">

            <thead>
                <tr>
                    <th>Reply</th>
                    <th>User</th>
                    <th>Timestamp</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($comments) {
                    foreach ($comments as $comment) {
                ?>
                        <tr>
                            <td><?= $comment['comment_text'] ?></td>
                            <td><?= $comment['user'] ?></td>
                            <td><?= $comment['timestamp'] ?></td>
                            <td>
                                <form class="status-form" method="POST" action="../admin/admin_forum_functions.php">
                                    <input type="hidden" name="post_id" value="<?= $comment['post_id'] ?>">
                                    <input type="hidden" name="comment_id" value="<?= $comment['comment_id'] ?>">
                                    <select name="active">
                                        <option value="1" <?= $comment['active'] == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= $comment['active'] == 0 ? 'selected' : '' ?>>Archived</option>
                                    </select>
                                    <button type="submit" name="update_comment">Update comment</button>
                                </form>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>






<?php
} else {
    header('Location: ../php/home.php');
    exit;
}

include('../includes/footer.php');
?>