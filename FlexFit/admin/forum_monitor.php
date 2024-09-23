<?php
session_start();
include('../includes/header.php');
include("../config/dbconfig.php");
include("../admin/admin_forum_functions.php");
include("../php/forum_functions.php");
$posts = getAdminPosts($pdo, "forum");

if (isset($_SESSION['authenticated_user']) && $_SESSION['authenticated_user']['role'] == 1) {
?>
    <link rel="stylesheet" text=" text/css" href="../css/admin.css">
    <div class="forum-table">
        <table class="forum-styling">
            <thead>
                <tr>
                    <th>Forum</th>
                    <th>Topics</th>
                    <th>Posts</th>
                    <th id="dateHeader" style="cursor: pointer;">Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($posts) {
                    foreach ($posts as $post) {
                ?>
                        <tr>
                            <td class="post">
                                <a href="post_moderation.php?post_id=<?= $post['id'] ?>"><?= $post['title'] ?></a><br><?= $post['post'] ?>
                            </td>
                            <td><?= $post['topic'] ?></td>
                            <td><?= numReplies($pdo, $post['id']) ?></td>
                            <td><?= $post['timestamp'] ?><br><?= $post['user'] ?></td>
                            <td>
                                <form class="status-form" method="POST" action="../admin/admin_forum_functions.php">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <select name="active">
                                        <option value="1" <?= $post['active'] == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= $post['active'] == 0 ? 'selected' : '' ?>>Archived</option>
                                    </select>
                                    <button type="submit" name="update_post">Update Post</button>
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