<head>
    <link rel="stylesheet" type="text/css" href="../css/forum.css">
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/chatacterCounter.js"></script>
</head>
<?php
session_start();
include('../includes/header.php');
include("../config/dbconfig.php");
include("../php/forum_functions.php");

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $stmt = $pdo->prepare("SELECT * FROM forum WHERE id = :post_id");
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $post = $stmt->fetch();

    if ($post) {
?>
        <div class="post-container">
            <div class="single-post">
                <h1><?= $post['title'] ?></h1>
                <p><?= $post['post'] ?></p>
                <p class="author">Posted by: <?= $post['user'] ?> <br> <?= $post['timestamp'] ?></p>

                <?php if (isset($_SESSION['authenticated_user']['fname'])) { ?>
                    <form class="post-comment" method="POST" action="../php/forum_functions.php">
                        <input type="hidden" name="post_id" value="<?= $post_id ?>">
                        <div class="comment-input">
                            <textarea id="comment-textarea" name="comment_text" placeholder="Add a comment..." autofocus></textarea>
                            <button type="submit">Post comment</button>
                        </div>
                        <div id="the-count">
                            <span id="current">0</span>
                            <span id="maximum">/ 300</span>
                        </div>
                    </form>
                <?php } else { ?>
                    <p>Please <a href="login.php">log in</a> to post a comment.</p>
                <?php } ?>
            </div>
        </div>
        <?php

        $stmt = $pdo->prepare("SELECT * FROM forumComments WHERE post_id = :post_id AND active = 1");
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        $comments = $stmt->fetchAll();

        if ($comments) {
            foreach ($comments as $comment) {
        ?>
                <div class="comment-container">
                    <div class="comments">
                        <p><?= $comment['comment_text'] ?></p>
                        <p class="author">Posted by: <?= $comment['user'] ?> <br> <?= $comment['timestamp'] ?></p>

                        <?php if (isset($_SESSION['authenticated_user']['id']) && $_SESSION['authenticated_user']['id'] === $comment['userid']) { ?>
                            <form method="POST" action="">
                                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                                <input type="hidden" name="delete_comment" value="<?= $comment['comment_id'] ?>">
                                <button class="delete-button" type="submit">Delete Comment</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
<?php
            }
        }
    } else {
        echo "Post not found";
    }
} else {
    echo "Post ID is missing in the URL.";
}

?>



<script>
    const textarea = document.getElementById('comment-textarea');

    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    textarea.dispatchEvent(new Event('input'));
</script>