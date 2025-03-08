<?php
require 'init.php';
session_regenerate_id(true);

if(!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

// Fetch post data based on ID from URL
$post_id = $_GET['post_id'];
$post_data = get_PostData($post_id);
$user_data = get_UserData($post_data['User_ID']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post - <?php echo $post_data['Caption']; ?></title>
    <link rel="icon" href="assets/images/event_accepted_50px.png" type="image/icon type">

    <!-- Add stylesheets and Bootstrap as before -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        
        .post-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .post-image img {
            width: 100%;
            border-radius: 10px;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .profile-icon img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .post-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-top: 15px;
            font-size: 1.2rem;
        }

        .comments-section {
            margin-top: 30px;
        }

        .comment {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 15px;
        }

        .comment img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .comment-body {
            background: #f1f1f1;
            padding: 10px;
            border-radius: 10px;
            width: 100%;
        }
    </style>
</head>

<body>
<div class="post-container">
    <!-- Post Header -->
    <div class="post-header">
        <div class="profile-icon">
            <img src="assets/images/profiles/<?php echo $user_data['Profile_Img']; ?>" alt="Uploader Profile">
        </div>
        <div>
            <h5><?php echo $user_data['profile_name']; ?></h5>
            <p class="text-muted"><?php echo $post_data['upload_date']; ?></p>
        </div>
    </div>

    <!-- Post Image and Description -->
    <div class="post-image">
        <img src="assets/images/posts/<?php echo $post_data['Img_Path']; ?>" alt="Post Image">
    </div>
    <p class="mt-3"><?php echo $post_data['Description']; ?></p>
    
    <!-- Post Actions (Like, Comment) -->
    <div class="post-actions">
        <i class="fas fa-heart" style="cursor: pointer; color: <?php echo $liked ? '#e74c3c' : '#555'; ?>;" onclick="toggleLike()"></i>
        <span id="like-count"><?php echo $post_data['like_count']; ?></span>
        <i class="fas fa-comment" style="cursor: pointer;"></i>
        <span><?php echo count($comments); ?> Comments</span>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
        <h6>Comments</h6>
        <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <img src="assets/images/profiles/<?php echo $comment['Profile_Img']; ?>" alt="User Profile">
            <div class="comment-body">
                <strong><?php echo $comment['username']; ?></strong>
                <p><?php echo $comment['content']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Add New Comment -->
    <form action="add_comment.php" method="POST" class="mt-3">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <textarea name="comment" class="form-control" rows="2" placeholder="Add a comment..." required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
    </form>
</div>

<script>
// Toggle like functionality
function toggleLike() {
    // Send AJAX request to update like status in the backend
    // Update the like count and icon color here on success
}
</script>

</body>
</html>
