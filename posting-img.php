<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

include('config.php');

if (isset($_POST['posting'])) {
    $ID = $_SESSION['id'];
    $caption = $_POST['caption'];
    $hashtags = $_POST['hash-tags'];
    $likes = 0;
    $date = date("Y-m-d H:i:s");

    // Check if an edited image is submitted
    if (isset($_POST['edited_image']) && !empty($_POST['edited_image'])) {
        // Handle the edited image (base64)
        $imageData = $_POST['edited_image'];
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = base64_decode($imageData);

        // Generate a unique name for the edited image
        $imageName = uniqid('edited_') . '.jpg';
        $imagePath = './assets/images/posts/' . $imageName;

        // Save the edited image to the server
        if (file_put_contents($imagePath, $imageData)) {
            // Insert the post with the edited image path
            $sql_query = "INSERT INTO Posts (User_ID, Likes, Img_Path, Caption, HashTags, Date_Upload) 
                          VALUES ($ID, $likes, '$imageName', '$caption', '$hashtags', '$date')";
            $stmt = $conn->prepare($sql_query);
            if ($stmt->execute()) {
                // Successfully inserted the post
                update_Posts($ID);
                header("location: post-uploader.php?success_message=Post Successfully updated");
                exit;
            } else {
                header("location: post-uploader.php?error_message=Error Occurred, try again - ERROR #008");
                exit;
            }
        } else {
            header("location: post-uploader.php?error_message=Failed to save the edited image");
            exit;
        }
    } else if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Handle the regular image upload
        $filename = $_FILES['image']['name'];
        $tempname = $_FILES["image"]["tmp_name"];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $random_number = rand(0, 10000000);
        $file_rename = 'File_' . date('Ymd') . $random_number;
        $file_complete = $file_rename . '.' . $file_extension;
        $folder = "./assets/images/posts/" . $file_complete;

        // Insert the post with the regular image
        $sql_query = "INSERT INTO Posts (User_ID, Likes, Img_Path, Caption, HashTags, Date_Upload) 
                      VALUES ($ID, $likes, '$file_complete', '$caption', '$hashtags', '$date')";
        $stmt = $conn->prepare($sql_query);

        if ($stmt->execute()) {
            move_uploaded_file($tempname, $folder);
            update_Posts($ID);
            header("location: post-uploader.php?success_message=Post Successfully updated");
            exit;
        } else {
            header("location: post-uploader.php?error_message=Error Occurred, try again - ERROR #008");
            exit;
        }
    } else {
        header("location: post-uploader.php?error_message=No image selected or an error occurred");
        exit;
    }
} else {
    header("location: post-uploader.php?error_message=Error Occurred, try again - ERROR #009");
    exit;
}

function update_Posts($user_id)
{
    include 'config.php';

    $insert_query = "UPDATE users SET POSTS = POSTS + 1 WHERE User_ID = $user_id;";
    $stmt = $conn->prepare($insert_query);

    if ($stmt->execute()) {
        $_SESSION['postcount'] = $_SESSION['postcount'] + 1;
    }
}
?>
