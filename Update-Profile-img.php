<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

include('config.php');

if (isset($_POST['posting'])) {
    $filename = $_FILES['image']['name'];
    $tempname = $_FILES["image"]["tmp_name"];
    $file_extansion = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    // Check if file type is valid
    $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_extansion, $valid_extensions)) {
        header("location: edit-profile.php?error_message=Invalid file type. Please upload an image.");
        exit;
    }


    $random_number = rand(0, 10000000);
    $file_rename = 'Profile_' . date('Ymd') . $random_number;
    $file_complete = $file_rename . '.' . $file_extansion;

    $folder = "./assets/images/profiles/" . $file_complete;

    // Move file to target folder
    if (!move_uploaded_file($tempname, $folder)) {
        header("location: edit-profile.php?error_message=Error uploading file, please try again.");
        exit;
    }

    $user_id = $_SESSION['id'];
    update_Profile($user_id, $file_complete);

    header("location: edit-profile.php?success_message=Profile image updated successfully.");
    exit;
} else {
    header("location: edit-profile.php?error_message=Error Occurred, try again - ERROR #009");
    exit;
}

function update_Profile($user_id, $file_name)
{
    include 'config.php';

    $insert_query = "UPDATE users SET IMAGE = '$file_name' WHERE User_ID = $user_id ;";

    $stmt = $conn->prepare($insert_query);

    if ($stmt->execute()) {

        $_SESSION['img_path'] = $file_name;
    }
}
?>