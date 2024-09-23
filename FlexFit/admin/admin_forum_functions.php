<?php
include('../config/dbconfig.php');
function getAdminPosts($pdo, $table)
{
    try {
        $query = "SELECT * FROM $table ORDER BY timestamp DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
        return false;
    }
}


function getAdminComments($pdo, $table, $postID)
{
    try {
        $query = "SELECT * FROM $table WHERE post_id = $postID ORDER BY timestamp ASC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
        return false;
    }
}


if (isset($_POST['update_comment']) && isset($_POST['comment_id']) && isset($_POST['active'])) {
    $comment_id = $_POST['comment_id'];
    $newStatus = $_POST['active'];

    try {
        $query = "UPDATE forumComments SET active = ? WHERE comment_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newStatus, $comment_id]);
        header('Location: ../admin/post_moderation.php?post_id=' . $_POST['post_id']);
        exit;
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
    }
}


if (isset($_POST['update_post']) && isset($_POST['post_id']) && isset($_POST['active'])) {
    $postId = $_POST['post_id'];
    $newStatus = $_POST['active'];

    try {
        $query = "UPDATE forum SET active = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newStatus, $postId]);
        header('Location: ../admin/forum_monitor.php');
        exit;
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
    }
}

?>