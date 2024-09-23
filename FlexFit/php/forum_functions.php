<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/dbconfig.php");

if (!isset($_SESSION['authenticated_user'])) {
    $_SESSION['authenticated_user'] = false;
}


function getAllPosts($pdo, $table)
{
    $sortOrder = "DESC"; // Default sorting order

    // Check if 'sort' parameter is present in the URL
    if (isset($_GET['sort'])) {
        // Validate the sorting order (e.g., ASC or DESC)
        $sort = strtoupper($_GET['sort']);
        if ($sort === "ASC" || $sort === "DESC") {
            $sortOrder = $sort;
        }
    }

    try {
        $query = "SELECT * FROM $table WHERE active=1 ORDER BY timestamp $sortOrder";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
        return false;
    }
}




function newPost($pdo, $table, $title, $post, $user, $userid, $topic){
    try {
        $query = "INSERT INTO $table (title, post, user, userid, topic) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(1, $title, PDO::PARAM_STR);
        $stmt->bindValue(2, $post, PDO::PARAM_STR);
        $stmt->bindValue(3, $user, PDO::PARAM_STR);
        $stmt->bindValue(4, $userid, PDO::PARAM_INT);
        $stmt->bindValue(5, $topic, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function numReplies($pdo, $post_id){
    try {
        $query = "SELECT COUNT(*) FROM forumComments WHERE post_id = :post_id AND active = 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count;
    } catch (PDOException $e) {
        return false;
    }
}



function getPostById($pdo, $table, $id)
{
    try {
        $query = "SELECT * FROM $table WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['comment_text'];
    $user = $_SESSION['authenticated_user']['fname'];
    $userid = $_SESSION["authenticated_user"]['id'];

    if (!empty($comment_text)) {
        $stmt = $pdo->prepare("INSERT INTO forumComments (post_id, comment_text, user, userid) VALUES (:post_id, :comment_text, :user, :userid)");
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':comment_text', $comment_text);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':userid', $userid);

        if ($stmt->execute()) {
            header("Location: ../php/post.php?post_id=$post_id"); 
        } else {
            echo "Error adding comment to the post";
        }
    } else {
        echo "Comment text cannot be empty.";
    }
}

function getPostOwner($pdo, $post_id)
{
    try {
        $query = "SELECT userid FROM forum WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(1, $post_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['userid'];
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}


function deletePost($pdo, $post_id)
{
    try {
        $query = "UPDATE forum SET active = 0 WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(1, $post_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}





function getCommentOwner($pdo, $comment_id)
{
    try {
        $query = "SELECT userid FROM forumComments WHERE comment_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(1, $comment_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['userid'];
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function deleteComment($pdo, $comment_id)
{
    try {
        $query = "UPDATE forumComments SET active = 0 WHERE comment_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(1, $comment_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}


if (isset($_POST['delete_comment']) && isset($_POST['post_id']) && isset($_SESSION['authenticated_user']['id'])) {
    $comment_id = $_POST['delete_comment'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['authenticated_user']['id'];

    $comment_owner = getCommentOwner($pdo, $comment_id);

    if ($comment_owner === $user_id) {
        if (deleteComment($pdo, $comment_id)) {
            header("Location: ../php/post.php?post_id=$post_id");
        } else {
            echo "Error deleting the comment.";
        }
    } else {
        echo "You do not have permission to delete this comment.";
    }
} 


?>