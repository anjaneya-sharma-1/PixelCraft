
<?php

session_start();

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

  <title>PixelCraft</title>

 

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

  <title>Document</title>

  <link rel="stylesheet" href="assets/css/style.css">

  <link rel="stylesheet" href="assets/css/responsive.css">

  <link rel="stylesheet" href="assets/css/edit-profile.css">

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

.btn-outline-primary {
    font-size: 14px; /* Set the font size for consistency */
    padding: 8px 16px; /* Ensure consistent padding */
    height: auto;  /* Ensure consistent height */
}

.btn-outline-primary.btn-sm {
    font-size: 14px; /* Adjust font size for small buttons */
    padding: 8px 16px; /* Ensure padding is consistent */
    height: auto; /* Ensure consistent height */
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

<br><br><br>

<!-- Profile edit Section - Preview Section -->

<div class="container">

  <div class="row gutters">

    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">

      <div class="card h-100">

        <div class="card-body">

          <div class="account-settings">

            <div class="user-profile-edit">

              <div class="user-avatar">

                <img src="<?php echo "assets/images/profiles/".$_SESSION['img_path'] ?>" alt="profile-avatar">

              </div>

              <h5 class="user-name"><?php echo $_SESSION['username']; ?></h5>

              <h6 class="user-email"><?php echo $_SESSION['fullname']?></h6>

            </div>

            <div class="about">

              <h5>About</h5>

              <p><?php echo $_SESSION['bio']?></p>

                <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fas fa-user-edit" ></i>Change Profile Pic</button>

                <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#passchange"><i class="fas fa-shield-alt"></i> Password & Security </button>

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

          </div>

        </div>

      </div>

    </div>

<!-- Profile edit Section - Edit Section -->

    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">

      <div class="card h-100">

<form method="POST" action="update-profile.php" enctype="multipart/form-data">
      <div class="card-body">

<div class="row gutters">

  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

     <h4 class="mb-2 " style="color:#d80000;">ACCOUNT SETTINGS</h4><br>

    <h6 class="mb-2 ">Personal Details</h6>

  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">

    <div class="form-group">

      <label for="fullName">Full Name</label>

      <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Enter full name/Organization Name" value="<?php echo $_SESSION['fullname'] ?>">

    </div>

  </div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">

    <div class="form-group">

      <label for="user_name">User Name</label>

      <input type="text" class="form-control" id="user_name" placeholder="Enter User Name" name="user_name" value="<?php echo $_SESSION['username']; ?>" >

    </div>

  </div>

  <div class="mb-3">

    <label for="exampleFormControlTextarea1" class="form-label" style="padding-top: 5px;">Describe Your Self</label>

    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="little bit about you" name="bio"><?php echo $_SESSION['bio'];?></textarea>

  </div>

  <div class="row gutters">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

      <h6 class="mt-3 mb-2 ">Social Links</h6>

  </div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">

    <div class="form-group">

      <label for="email">Email Address</label>

      <input type="email" class="form-control" id="email" placeholder="Enter email address" name="email" value="<?php echo $_SESSION['email'];?>">

    </div>

  </div>




</div>

  <div class="row gutters">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

      <div class="text-right">

        <br><button type="submit" id="cancel" name="submits" class="btn btn-secondary">Cancel</button>

        <button type="submit" id="submit-data" name="submit" class="btn btn-primary">Update</button>

      </div>

    </div>

  </div>

</div>

</div>

</form>

      </div>

    </div>

  </div>


</div>

</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel" >Change Profile Picture</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="Update-Profile-img.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Choose Your Profile Image : </label>

                        <input class="form-control form-control-sm" id="formFileSm" type="file" name="image">

                    </div>

                    <button type="submit" class="btn btn-outline-primary btn-sm mt-2" name="posting"><i class="fas fa-cloud-upload-alt"></i>Upload Image</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="passchange" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel" >Change Password</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="Change-Pass.php">

                    <label for="inputPassword5" class="form-label">Old Password</label>
                    <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" name="old-password">

                    <label for="inputPassword5" class="form-label">New Password</label>
                    <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" name="new-password">

                    <label for="inputPassword5" class="form-label">Retype Password</label>
                    <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" name="retype-password">
                    <div id="passwordHelpBlock" class="form-text">
                        Your New password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                    </div>

                    <button type="submit" class="btn btn-outline-primary btn-sm mt-2" name="change-password"><i class="fas fa-cloud-upload-alt"></i> Change Password</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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

<script src="notifast/notifast.min.js"></script>

<script src="notifast/function.js"></script>

<script type="text/javascript">
    document.getElementById("logo-img").onclick = function () {
        location.href = "home.php";
    };
</script>

</html>