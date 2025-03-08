<?php

session_start();

function find_Users($search_input)
{
    include "config.php";

    $SQL = "SELECT * FROM users WHERE FULL_NAME LIKE '%$search_input%' OR USER_NAME LIKE '%$search_input%';";

    $stmt = $conn->prepare($SQL);

    $stmt->execute();

    $users = $stmt->get_result();

    return $users;
}



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






