<?php

session_start();



function get_My_Followers()
{
    include "config.php";

    $my_id = $_SESSION['id'];

    $SQL = "SELECT * FROM fallowing WHERE Other_user_id = $my_id;";

    $stmt = $conn->prepare($SQL);

    $stmt->execute();

    $users = $stmt->get_result();

    return $users;
}

function get_My_Followings()
{
    include "config.php";

    $my_id = $_SESSION['id'];

    $SQL = "SELECT * FROM fallowing WHERE User_Id = $my_id;";

    $stmt = $conn->prepare($SQL);

    $stmt->execute();

    $users = $stmt->get_result();

    return $users;
}






