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
$posts = getAllPosts($pdo, "forum");

$showCreatePostButton = isset($_SESSION['authenticated_user']['id']);

if (isset($_POST['submit'])) {
  if ($showCreatePostButton) {
    $title = $_POST['title'];
    $topic = $_POST['topic'];
    $post = $_POST['post'];
    $user = $_SESSION['authenticated_user']['fname'];
    $userid = $_SESSION['authenticated_user']['id'];
    $result = newPost($pdo, "forum", $title, $post, $user, $userid, $topic);
    if ($result) {
      header("Location: ../php/forum.php");
    } else {
      echo "Error adding post to the forum";
    }
  } else {
    echo "You are not logged in. Please log in to post to the forum!";
  }
}


if (isset($_POST['delete_post']) && isset($_SESSION['authenticated_user']['id'])) {
  $post_id_to_delete = $_POST['delete_post'];
  $user_id = $_SESSION['authenticated_user']['id'];

  // Check if the user is the owner of the post
  $post_owner = getPostOwner($pdo, $post_id_to_delete);
  if ($post_owner === $user_id) {
    // Delete the post
    $result = deletePost($pdo, $post_id_to_delete);
    if ($result) {
      echo "Post have been deleted";
      header("Location: ../php/forum.php");
    } else {
      echo "Error deleting post.";
    }
  } else {
    echo "You do not have permission to delete this post.";
  }
}
?>





<form class="post-forum" method="POST" enctype="multipart/form-data" id="postForm" style="display: none;">
  <div class="fields">
    <input type="text" name="title" placeholder="Title">
    <select name="topic">
      <option value="Supplement Reviews and Recommendations">Supplement Reviews and Recommendations</option>
      <option value="Workout and Training Routines">Workout and Training Routines</option>
      <option value="Gym Membership Advice">Gym Membership Advice</option>
      <option value="Fitness Progress Journals">Fitness Progress Journals</option>
      <option value="Motivation and Inspiration">Motivation and Inspiration</option>
      <option value="Injury Prevention and Recovery">Injury Prevention and Recovery</option>
      <option value="Supplement Safety and Warnings">Supplement Safety and Warnings</option>
    </select>
  </div>
  <textarea id="forum-textarea" name="post" placeholder="Post" autofocus></textarea>
  <div id="character-counter">
    <span id="current">0</span>
    <span id="maximum">/ 350</span>
  </div>
  <input type="submit" name="submit" value="Submit">
</form>



<div class="user-buttons">
  <?php if ($showCreatePostButton) { ?>
    <button id="showPostForm">Create a post</button>
    <button>Your Posts</button>
  <?php } else { ?>
    <div class="not-authenticated">
      <p>You are not logged in. Please <a href="login.php">log in</a> to post to the forum or <a href="shop.php">return to shop</a>.</p>
    </div>
  <?php } ?>
</div>

<form>
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
                <a href="post.php?post_id=<?= $post['id'] ?>"><?= $post['title'] ?></a><br><?= $post['post'] ?>
              </td>
              <td><?= $post['topic'] ?></td>
              <td><?= numReplies($pdo, $post['id']) ?></td>
              <td><?= $post['timestamp'] ?><br><?= $post['user'] ?></td>
              <td>
                <?php
                if (isset($_SESSION['authenticated_user']) && isset($_SESSION['authenticated_user']['id']) && $post['userid'] === $_SESSION['authenticated_user']['id']) {
                ?>

                  <form method="POST" action="">
                    <input type="hidden" name="delete_post" value="<?= $post['id'] ?>">
                    <button class="delete-button" type="submit">Delete Post</button>
                  </form>
                <?php
                }
                ?>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='4'>No posts available</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</form>


<script>
  document.getElementById('showPostForm').addEventListener('click', function() {
    const postForm = document.getElementById('postForm');
    postForm.style.display = postForm.style.display === 'none' ? 'block' : 'none';
  });


  const textarea = document.getElementById('forum-textarea');

  textarea.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
  });

  textarea.dispatchEvent(new Event('input'));
</script>


<script>
  document.addEventListener("DOMContentLoaded", function() {
    const dateHeader = document.getElementById("dateHeader");
    let sortOrder = "DESC";

    dateHeader.addEventListener("click", function() {
      sortOrder = sortOrder === "DESC" ? "ASC" : "DESC";
      // Reload the page with the updated query parameter
      window.location.href = `forum.php?sort=${sortOrder}`;
    });
  });
</script>



<?php include('../includes/footer.php') ?>