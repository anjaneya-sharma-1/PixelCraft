<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>PixelCraft</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/profile-page.css">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<style>
.bgimg 
    {
      background-image: url('assets/images/login_request/cover.png');
      
      min-height: 100vh;
      
      background-position: center;
      background-attachment: fixed;
      background-size: cover;
    }
    body{
        color:white;
    }
    .fallow-btns{
        background-color:red;
    }
    
    .custom-hr {
            width: 50%; /* Adjust the width as needed */
            margin: 20px auto; /* Centers the line horizontally with spacing */
            border: 0;
            border-top: 2px solid white; /* Stylish white line with 2px thickness */
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); /* Optional: adds a glowing effect */
        }

        .navbar {
    padding: 0.5rem 1rem;
    
    background-color: black;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.navbar-brand .brand-img {
    height: 40px;
    cursor: pointer;
}

.navbar-toggler {
    border: none;
    outline: none;
}

.nav-items {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.icon, .icon-add, .user-profile i {
    font-size: 1.6rem; /* Consistent size for all icons */
    color: white;
    cursor: pointer;
}

/* Profile icon styling adjustments */
.user-profile {
    display: inline-flex;      /* Ensure no extra spacing */
    align-items: center;
    text-decoration: none;     /* Remove any underline from the anchor */
    color: inherit;            /* Inherit color for consistency */
    line-height: 1;            /* Remove extra line height */
}

.user-profile i {
    font-size: 1.8rem;         /* Consistent size with other icons */
    color: white;
}

.user-profile:hover i {
    color: #007bff;            /* Add hover effect */
}

/* Additional reset in case */
.user-profile a {
    text-decoration: none;     /* Remove underline */
    color: inherit;            /* Ensure color is inherited */
}


.icon:hover, .icon-add:hover, .user-profile i:hover {
    color: red;
}

    body{
        color:white;

    }
</style>
<body>
<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
<nav class="navbar navbar-expand-lg navbar-light bg-black shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
            <img src="assets/images/login_request/small_logo2.png" alt="Brand Logo" class="brand-img">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="nav-items d-flex align-items-center gap-4">
                <i class="icon fas fa-search" data-bs-toggle="modal" data-bs-target="#search-model"></i>
                <i class="icon icon-add fas fa-plus-square" onclick="window.location.href='post-uploader.php'"></i>
                
                <a href="my_Profile.php" class="user-profile">
                    <i class="fas fa-user-circle"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
<?php
include("config.php");

if (isset($_POST['target_id'])) {
    $target_id = $_POST['target_id'];
    $sql = "SELECT * FROM Users WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $target_id);
    if ($stmt->execute()) {
        $user_array = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        header("location: home.php");
        exit;
    }
} else {
    header("location: home.php");
}
?>
<?php include('Check_FallowStatus.php');?>
<header class="profile-header">
  <div class="profile-container">
    <?php foreach ($user_array as $array_user) { ?>
    <div class="profile">
      <div class="profile-image">
        <img src="<?php echo 'assets/images/profiles/' . $array_user['IMAGE']; ?>" alt="Profile Picture">
      </div>
      <div class="profile-user-settings">
        <h1 class="profile-user-name"><?php echo $array_user['USER_NAME']; ?></h1>
      </div>
      <div class="profile-status">
        <ul>
          <li><span class="profile-status-count"><?php echo $array_user['POSTS']; ?></span> Posts</li>
          <li><span class="profile-status-count"><?php echo $array_user['FOLLOWING']; ?></span> Following</li>
          <li><span class="profile-status-count"><?php echo $array_user['FOLLOWERS']; ?></span> Followers</li>
        </ul>
      </div>
      <div class="social">
        <ul>
          <li><i class="fas fa-envelope"></i> Email: <?php echo $array_user['EMAIL']; ?></li>
        </ul>
      </div>
      <div class="profile-bio">
        <p><span class="profile-real-name"><?php echo $array_user['FULL_NAME']; ?></span><br> <?php echo $array_user['BIO']; ?></p>
      </div>
      <form action="<?php echo $following_status ? 'Unfollow_User.php' : 'fallow_user.php'; ?>" method="post">
        <input type="hidden" name="<?php echo $following_status ? 'other_User_Id' : 'fallow_person'; ?>" value="<?php echo $array_user['User_ID']; ?>">
        <button type="submit" class="fallow-btns"><?php echo $following_status ? 'Unfollow' : 'Follow'; ?></button>
      </form>
    </div>
    <?php } ?>
  </div>
  <hr class="custom-hr">
</header>

<main>

  <div class="profile-container">
    <div class="gallery">
      <?php include("get_targetPosts.php"); ?>
      <?php foreach ($posts as $post) { ?>
      <div class="gallery-items">
        <img src="<?php echo './assets/images/posts/' . $post['Img_Path']; ?>" alt="Post" class="gallery-img">
        <div class="gallery-item-info">
          <ul>
            <li class="gallery-items-likes">
              <span class="hide-gallery-elements">Reactions: <?php echo $post['Likes']; ?></span>
              <i class="icon fas fa-thumbs-up"></i>
            </li>
            <li class="gallery-items-comments">
              <a href="single-post.php?post_id=<?php echo $post['Post_ID']; ?>" target="_blank" style="color: white">
                <i class="icon fas fa-comment"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</main>

<script>
  document.getElementById("logo-img").onclick = function () {
    location.href = "home.php";
  };
</script>
</div>
</body>

</html>
