<!DOCTYPE html>
<html lang="en">
<?php

require 'init.php';

session_regenerate_id(true);

$function_out = strcmp($_SESSION['usertype'], '1');

if(!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

  $_SESSION['edited_image'] = 0; 



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form contains an uploaded image or an edited image
    if (isset($_FILES['image'])) {
        // Handle direct image upload
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $imagePath = 'uploads/' . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Successfully uploaded, you can save the image path to the database here if needed
            $_SESSION['image_path'] = $imagePath;
        } else {
            echo "Failed to upload image.";
        }
    } elseif (isset($_POST['edited_image'])) {
        // Handle the edited image (base64 encoded image from the canvas)
        $editedImage = $_POST['edited_image'];
        $imageData2 = str_replace('data:image/jpeg;base64,', '', $editedImage);
        $imageData = base64_decode($imageData2);

        $imageName = uniqid('edited_') . '.jpg';

        $imagePath = 'uploads/' . $imageName;

        if (file_put_contents($imagePath, $imageData)) {
            // Successfully saved the edited image, you can save this to the database if needed
            $_SESSION['image_path'] = $imagePath;
            $_SESSION['edited_image'] = 1;
        } else {
            echo "Failed to save the edited image.";
        }
    }
}
?>



<head>
  <meta charset="UTF-8">
  <title>PixelCraft</title>
  <link rel="icon" href="assets/images/event_accepted_50px.png" type="image/icon type">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/section.css">
  <link rel="stylesheet" href="assets/css/posting.css">
  <link rel="stylesheet" href="assets/css/right_col.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
  <link rel="stylesheet" href="assets/css/camara-upload.css">
  <link rel="stylesheet" href="assets/css/links.css">
  <link rel="stylesheet" href="assets/css/bg-img.css">
  <link rel="stylesheet" href="notifast/notifast.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
  .btn{
    background-color:#d32f2f;
    border-color:#d32f2f;
  }
  .btn:hover{
    background-color:#f44336;
  }
</style>
<body>

<iframe src="naviibar.html" style="border:none; width:100%; height:60px; position:fixed; "></iframe>
<div class="bgimg w3-display-container w3-animate-opacity ">

<br><br><br>

<div class="container">
  <div class="row">
    <div class="col">
      <div class="mb-5">
        <form id ="uploadForm" method="post" action="posting-img.php" enctype="multipart/form-data">
          <div class="form-group">
              <h1 class="profile-user-name" style="font-size: 2rem;font-weight: 300; color:white;">New Post</h1>
          </div><br>
          <div class="form-group">
            <label for="caption" style="color:white;">What On Your Mind</label>
            <textarea type="text" class="form-control" id="caption" rows="4"  placeholder="caption here" onchange="get_caption();" name="caption" maxlength="500"></textarea>
          </div><br>
          <div class="form-group">
            <label for="tag-id" style="color:white;">Hash Tags</label>
            <input type="text" class="form-control" id="tag-id" aria-describedby="caption-area" placeholder="Hash Tags" onchange="get_hash();" name="hash-tags">
          </div><br>
          <div class="form-group">
            <label for="tag-id" style="color:white;">Add Media (Image Files Only Accept)</label>
            <input class="form-control" type="file" id="formFile" onchange="preview()" name="image">
          </div>
          <br>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" name="posting">Submit</button>
            <button onclick="clearImage()" class="btn btn-primary">Clear Preview</button>
            <!-- New Edit Button -->
            <button type="submit" formaction="edit.php" class="btn btn-secondary" name="edit">Edit Image</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col sm-hidden">
      <h1 class="profile-user-name" style="font-size: 2rem;font-weight: 300;color:white;">Preview Post</h1><br>
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
      <div class="post">
        <div class="info">
          <div class="user">
            <div class="profile-pic"><img src="assets/images/temp_profile.webp"></div>
            <p class="username">Preview Post</p>
          </div>
          <i class="fas fa-ellipsis-v options"></i>
        </div>
        <img src="assets/images/no-photo.png" id="frame" class="post-img">
        <div class="post-content">
          <div class="reactions-wrapper">
            <i class="icon fas fa-thumbs-up"></i>
            <i class="icon fas fa-comment"></i>
          </div>
          <p class="description" id="caption-data">
            <span>Caption : <br></span>
            Description is a spoken or written account of a person, object, or event. It can also mean a type or class of people or things. Description is not a word.
          </p>
          <p class="post-time" id="current-date">2022/11/5</p>
          <p class="post-time" id="hash-tags" style="color: #3942e7;"><i>#hashtag #hashtags</i></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/preview-helper.js"> </script>
<?php
if (isset($_SESSION['edited_image']) && $_SESSION['edited_image'] == 1) {
    if (isset($_SESSION['image_path'])) {
      
        echo "<script >
            
            frame.src=('".$imagePath."');
        
    

    var canvasData = '".$imageData2."';
        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'edited_image';
        hiddenInput.value = canvasData;
        
        
        document.getElementById('uploadForm').appendChild(hiddenInput);
</script>";
    $_SESSION['edited_image'] = 0; 
}}
?>
<script src="notifast/notifast.min.js"></script>
<script src="notifast/function.js"></script>
<script type="text/javascript">
    document.getElementById("logo-img").onclick = function () {
        location.href = "home.php";

    };
</script>
  </div>
</body>

</html>
