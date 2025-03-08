<?php
session_start();

// Directory for uploaded images
$uploadsDir = 'uploads';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0777, true);
}

// Check if an image has been uploaded
$imageSrc = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
    $imagePath = "$uploadsDir/$imageName";

    // Move uploaded file to the uploads directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $imageSrc = $imagePath;
    } else {
        echo "Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Simple Image Editor</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<style>
    .restStuff{
        margin-top:40px;
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
.bgimg 
    {
      background-image: url('assets/images/login_request/cover.png');
      
      min-height: 100vh;
      
      background-position: center;
      background-attachment: fixed;
      background-size: cover;
    }
</style>

<body>
<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
<nav class="navbar navbar-expand-lg navbar-light bg-black shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="assets/images/login_request/small_logo2.png" alt="Brand Logo" class="brand-img">
</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="nav-items d-flex align-items-center gap-4">
            <button class="white black-text" onclick="saveImage()">Save</button>
            <button class="red white-text" onclick="resetImage()">Reset</button>
            </div>
        </div>
    </div>
</nav>


    </nav>
    <div class="restStuff">
    <img id="sourceImage" crossorigin="anonymous" src="<?php echo $imageSrc; ?>">
    <div id="editorSection" class="editor-section" >
        <div class="image-preview">
            <canvas id="canvas" height="0"></canvas>
        </div>
        <div class="container app">
        <div class="image-controls">
        <h6>Image Controls</h6>
        <div class="row">
            <div class="col s6">
                <label for="brightnessSlider">Brightness</label>
                <input id="brightnessSlider" type="range" value="100" min="0" max="300" onchange="applyFilter()" class="form-range custom-slider">
            </div>
            <div class="col s6">
                <label for="contrastSlider">Contrast</label>
                <input id="contrastSlider" type="range" value="100" min="0" max="200" onchange="applyFilter()" class="form-range custom-slider">
            </div>
        </div>

        <div class="row">
            <div class="col s6">
                <label for="grayscaleSlider">Grayscale</label>
                <input id="grayscaleSlider" type="range" value="0" min="0" max="100" onchange="applyFilter()" class="form-range custom-slider">
            </div>
            <div class="col s6">
                <label for="saturationSlider">Saturation</label>
                <input id="saturationSlider" type="range" value="100" min="0" max="300" onchange="applyFilter()" class="form-range custom-slider">
            </div>
        </div>

        <div class="row">
            <div class="col s6">
                <label for="sepiaSlider">Sepia</label>
                <input id="sepiaSlider" type="range" value="0" min="0" max="200" onchange="applyFilter()" class="form-range custom-slider">
            </div>
            <div class="col s6">
                <label for="hueRotateSlider">Hue</label>
                <input id="hueRotateSlider" type="range" value="0" min="0" max="360" onchange="applyFilter()" class="form-range custom-slider">
            </div>
        </div>
    </div>

            <div class="preset-filters">
                <h6 >Preset Filters</h6>
                <button class="btn " onclick="brightenFilter()">Brighten</button>
                <button class="btn " onclick="bwFilter()">Black and White</button>
                <button class="btn " onclick="funkyFilter()">Funky</button>
                <button class="btn " onclick="vintageFilter()">Vintage</button>
            </div>

            <div class="clipart-controls">
                <h6>Add Image</h6>
                <input type="file" accept="image/*" onchange="addClipartMode(event)">
            </div>

            <div class="text-controls">
                <select id="fontSelect">
                    <option value="Arial">Arial</option>
                    <option value="Verdana">Verdana</option>
                    <option value="Times New Roman">Times New Roman</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Courier New">Courier New</option>
                </select>
                <input type="text" id="textInput" placeholder="Enter text here">
                <button onclick="addText()">Add Text</button>
            </div>
        </div>
    </div>
    <!-- Add this form in your HTML (hidden form for submitting the edited image) -->
<form id="submitForm" action="post-uploader.php" method="POST" style="display:none;">
    <input type="hidden" name="edited_image" id="editedImage">
    <input type="hidden" name="original_image" value="<?php echo $imageSrc; ?>"> <!-- Optional: Send the original image path if needed -->
    <button type="submit" id="submitButton">Submit Edited Image</button>
</form>
</div>

<!-- Script to capture the canvas and submit it -->
<script>
    function saveImage() {
        // Capture the edited image from the canvas as a data URL (base64 encoded)
        const canvas = document.getElementById('canvas');
        const editedImageData = canvas.toDataURL('image/jpeg'); // You can also use PNG if needed

        // Set the captured image data to the hidden input field
        document.getElementById('editedImage').value = editedImageData;

        // Submit the form to send the image back to post-uploader.php
        document.getElementById('submitForm').submit();
    }
</script>


    <script src="script.js"></script>
    <script>
    const imageSrc = '<?php echo $imageSrc; ?>';
</script>
</div>
</body>

</html>
