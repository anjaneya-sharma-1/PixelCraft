
<?php

require 'init.php';

session_regenerate_id(true);

include('config.php');

include('functions.php');

if(isset($_POST['submit']))
{
    $ID = $_SESSION['id'];

    $full_name = $_POST['full_name'];

    $user_name= $_POST['user_name'];

    $email_address= $_POST['email'];

    $bio = $_POST['bio'];



    if($user_name != $_SESSION['username'])
    {
        $sql_query = "SELECT USER_NAME FROM USERS WHERE USER_NAME = '$user_name';";

        echo $sql_query;

        $stmt = $conn->prepare($sql_query);

        $stmt->execute();

        $stmt->store_result();

        if($stmt->num_rows() > 0)
        {
            header('location: edit-profile.php?error_message=User Name Already Taken');

            exit;
        }
        else
        {
            Update_Profile($ID, $full_name, $user_name, $email_address, $bio);
        }
    }
    else
    {
        Update_Profile($ID, $full_name, $user_name, $email_address,$bio);
    }

}
else
{
    header("location: edit-profile.php");

    exit;
}

?>