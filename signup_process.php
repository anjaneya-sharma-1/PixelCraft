<?php

session_start();
include('config.php');

if (isset($_POST['signup_btn'])) {
    $email_address = $_POST['email'];
    $full_name = $_POST['full_name'];
    $user_name = $_POST['username'];
    $user_type = "1";
    $bio = "Tell us more about yourself";
    $followers = 0;
    $following = 0;
    $post_count = 0;
    $image = "default.png";
    $password = md5($_POST['password']);
    $domain_validation = 1;

    if ($domain_validation != 0) {
        // User availability check in the system
        $sql_query = "SELECT User_ID FROM USERS WHERE EMAIL = '$email_address';";
        $stmt = $conn->prepare($sql_query);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header('location: create-account.php?error_message=Your Email Account is already registered.');
            exit;
        } else {
            $insert_query = "INSERT INTO users (FULL_NAME, USER_NAME, USER_TYPE, PASSWORD_S, EMAIL, IMAGE, BIO, FOLLOWERS, FOLLOWING, POSTS) VALUES
                ('$full_name', '$user_name', '$user_type', '$password', '$email_address', '$image', '$bio', $followers, $following, $post_count);";

            $stmt = $conn->prepare($insert_query);

            if ($stmt->execute()) {
                $_SESSION['username'] = $user_name;
                $_SESSION['fullname'] = $full_name;
                $_SESSION['email'] = $email_address;
                $_SESSION['usertype'] = $user_type;
                $_SESSION['bio'] = $bio;
                $_SESSION['followers'] = $followers;
                $_SESSION['following'] = $following;
                $_SESSION['postcount'] = $post_count;
                $_SESSION['img_path'] = $image;

                header("location: Welcome.php");
            } else {
                header("location: create-account.php?error_message=Error occurred #008");
                exit;
            }
        }
    } else {
        header("location: create-account.php?error_message=This system does not support external email addresses.");
        exit;
    }
} else {
    header("location: create-account.php?error_message=Error occurred #009");
    exit;
}

function full_name($email) {
    return strstr($email, '@', true);
}
