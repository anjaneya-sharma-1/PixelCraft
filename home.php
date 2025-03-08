<?php
require 'init.php';
session_regenerate_id(true);
if(!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pinboard - Recent Posts</title>
    <link rel="icon" href="assets/images/event_accepted_50px.png" type="image/icon type">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/section.css">
    
    <link rel="stylesheet" href="assets/css/posting.css">

    <link rel="stylesheet" href="assets/css/responsive.css">

    <link rel="stylesheet" href="assets/css/right_col.css">
    
    <link rel="stylesheet" href="assets/css/profile-page.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<style>
    body {
        background-color: #f0f2f5;
        font-family: Arial, sans-serif;
    }

    /* Navigation bar */
/* Updated Navbar Styling */
/* Updated Navbar Styling */
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

/* Responsive adjustments */
@media (max-width: 768px) {
    .nav-items {
        gap: 1rem;
    }
}



    
    .pinboard {
        column-count: 4; /* Creates a masonry effect */
        column-gap: 15px;
        padding: 20px;
        max-width: 1200px;
        margin: auto;
    }

    /* Pin (post) styling */
    .pin {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        break-inside: avoid; /* Avoids breaking images across columns */
    }

    .pin img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 10px;
    }

    /* Hover overlay */
    .pin:hover .overlay {
        opacity: 1;
        
    }
    .pin:hover{
        cursor:pointer;
    }
    
    .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 0.9rem;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .pinboard {
            column-count: 3;
        }
    }

    @media (max-width: 768px) {
        .pinboard {
            column-count: 2;
        }
    }

    @media (max-width: 576px) {
        .pinboard {
            column-count: 1;
        }
    }
    .bgimg 
    {
      background-image: url('assets/images/login_request/cover.png');
      
      min-height: 100vh;
      
      background-position: center;
      background-attachment: fixed;
      background-size: cover;
    }
    

</style>

</head>

<body>
<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
     <!-- Nav Bar Design -->
    <!-- Updated Nav Bar Design -->
<!-- Updated Nav Bar Design -->
<nav class="navbar navbar-expand-lg navbar-light bg-black shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="assets/images/login_request/small_logo2.png" alt="Brand Logo" class="brand-img">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="nav-items d-flex align-items-center gap-4">
                <i class="icon fas fa-search" data-bs-toggle="modal" data-bs-target="#search-model"></i>
                <i class="icon icon-add fas fa-plus-square" onclick="window.location.href='post-uploader.php'"></i>
                <?php if (strcmp($_SESSION['usertype'], '1') != 0) { ?>
                    <i class="icon fas fa-plus-square" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                <?php } ?>
                <a href="my_Profile.php" class="user-profile">
                    <i class="fas fa-user-circle"></i>
                </a>
            </div>
        </div>
    </div>
</nav>



    <!-- Main Pinboard Section -->
    <section class="pinboard">
        <?php
        include('get_latest_posts.php');
        include('get_dataById.php');
        foreach($posts as $post) {
            $data = get_UserData($post['User_ID']);
            $profile_name = $data[0];
        ?>
            <div class="pin" onclick="window.location.href='single-post.php?post_id=<?php echo $post['Post_ID']; ?>'">
                <img src="<?php echo "assets/images/posts/" . $post['Img_Path']; ?>" alt="Post Image">
                <div class="overlay">
                    <p><strong><?php echo $profile_name; ?></strong></p>
                    <p><?php echo $post['Caption']; ?></p>
                </div>
            </div>
        <?php } ?>
    </section>

    <!-- Search Modal -->
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
</body>
</html>
