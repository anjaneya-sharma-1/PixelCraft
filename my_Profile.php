<?php

require 'init.php';

session_regenerate_id(true);

if(!isset($_SESSION['id']))
{
  header('location: login.php');

  exit;
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">

  <title>Title</title>

  <link rel="icon" href="assets/images/event_accepted_50px.png" type="image/icon type">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

  <title>Document</title>

  <link rel="stylesheet" href="assets/css/style.css">

  <link rel="stylesheet" href="assets/css/profile-page.css">

  <link rel="stylesheet" href="assets/css/section.css">

  <link rel="stylesheet" href="assets/css/posting.css">

  <link rel="stylesheet" href="assets/css/right_col.css">

  <link rel="stylesheet" href="assets/css/responsive.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="notifast/notifast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    .profile-edit-button:hover{
        background-color:red;
        border-color:red;
        
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

<header class="profile-header">

  <div class="profile-container">

    <div class="profile">

      <div class="profile-image">

        <img src="assets\images\profiles\<?php echo $_SESSION['img_path'] ?>" alt="profile picture">
        

      </div>

      <div class="profile-user-settings">

        <h1 class="profile-user-name"><?php echo $_SESSION['username']; ?></h1>

        <a href="edit-profile.php" style="color:white;"><button class="profile-button profile-edit-button">Edit Profile</button><a>

        <button class="profile-button profile-settings-btn" aria-label="profile settings" data-bs-toggle="modal" data-bs-target="#exampleModal">

        <a href="logout.php" style="text-decoration: none; color: #1c1f23"><i class="icon fas fa-sign-out-alt fa-lg"></i></a>

        </button>



        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

          <div class="modal-dialog">

            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Quick Actions</h5>
              </div>

                <div class="modal-body">
                  <ul style="list-style: none; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 10px; text-decoration: none;">
                    <li><button class="profile-button profile-settings-btn"><i class="icon fas fa-cog"></i></button><a href="edit-profile.php">Profile Edit<a></li>

                    <li><button class="profile-button profile-settings-btn"><i class="icon fas fa-sign-out-alt"></i></i></button><a href="logout.php">Log Out</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
      </div>

        <?php if(isset($_GET['error_message'])){ ?>

            <?php

            $message = $_GET['error_message'];

            echo"<body onload='notification_function(`Error Message`, `$message`, `#da1857`);'</body>"

            ?>

        <?php }?>

        <?php if(isset($_GET['success_message'])){ ?>

            <?php

            $message = $_GET['success_message'];

            echo"<body onload='notification_function(`Success Message`, `$message`, `#0F73FA`);'</body>"

            ?>

        <?php }?>
      
      <!--<div class="popup" id="popup">

          <div class="popup-window">


          </div>
        
        </div>

      </div>-->

      <div class="profile-status">

        <ul>
          <li><span class="profile-status-count">4</span> Posts</li>

          <li><span class="profile-status-count"><?php echo $_SESSION['fallowing'] ?></span> Following</li>

          <li><span class="profile-status-count"><?php echo $_SESSION['fallowers'] ?></span> Followers</li>

        </ul>

      </div>

      <div class="social">

        <ul>
          <li><i class="fas fa-envelope fa-lg"></i><?php echo " ".$_SESSION['email'] ?></li>



          <i class="fad fa-campfire"></i>

        </ul>

      </div>
            
      <div class="profile-bio">

        <p><span class="profile-real-name"><?php echo $_SESSION['fullname']?></span> <br><?php echo " ".$_SESSION['bio']?> </p>

      </div>

    </div>

  </div>

</header>

<!-- design photo gallery -->

<main>

  <div class="profile-container">

    <div class="gallery">

    <?php include("get-posts.php"); ?>

     <!--loop over the results-->

    <?php foreach($posts as $post){ ?>

      <div class="gallery-items">
      <a href="single-post.php?post_id=<?php echo $post['Post_ID'];?>" style="color: white" target="_blank">
        <img src="<?php echo "./assets/images/posts/".$post['Img_Path'];?>" alt="post" class="gallery-img">
        
        <div class="gallery-item-info">

          <ul>

            <li class="gallery-items-likes"><span class="hide-gallery-elements">Reactions : <?php echo $post['Likes'];?></span>

              <i class="icon fas fa-thumbs-up"></i>
              <li class="gallery-items-likes"><span class="hide-gallery-elements">Opinions</span>
              <i class="icon fas fa-comment"></i>
            </li><br>
            
          </ul>

        </div>
        </a>
      </div>
      
    <?php } ?>
    <div class="modal fade" id="search-model" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="Results.php">
                        <input type="search" name="find" class="form-control" placeholder="Search" aria-label="Search">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

  </main>

</body>

<script src="notifast/notifast.min.js"></script>

<script src="notifast/function.js"></script>

</html>