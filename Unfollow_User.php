<?php

session_start();

include("config.php");

$user_id = $_SESSION['id'];
$unfollow_person = $_POST['other_User_Id'];

// Prepare and execute the query to get the follow entry
$get_Id = "SELECT ID FROM fallowing WHERE User_Id = ? AND Other_user_id = ?";
$stmt = $conn->prepare($get_Id);
$stmt->bind_param("ii", $user_id, $unfollow_person);
$stmt->execute();
$stmt->bind_result($target_id);
$stmt->fetch();
$stmt->close();

// Check if a follow record exists
if ($target_id) {
    // Delete the follow record
    $sql = "DELETE FROM fallowing WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $target_id);
    $stmt->execute();
    $stmt->close();

    // Update followers and following counts
    update_Following($user_id);
    update_Followers($unfollow_person);

    // Decrease the following count in session
    $_SESSION['fallowing'] = $_SESSION['fallowing'] - 1;

    // Redirect back to the profile page using a hidden form
    echo '<form id="redirectForm" method="post" action="follower_acc.php">
            <input type="hidden" value="' . $unfollow_person . '" name="target_id">
          </form>';

    // JavaScript to automatically submit the form
    echo '<script type="text/javascript">
            document.getElementById("redirectForm").submit();
          </script>';
} else {
    // Handle the case where the follow record wasn't found (optional)
    echo "Error: No such follow record found.";
}

function update_Following($user_id)
{
    include("config.php");

    // Prepare and execute the query to decrement following count
    $sql = "UPDATE users SET FOLLOWING = FOLLOWING - 1 WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

function update_Followers($other_Person)
{
    include("config.php");

    // Prepare and execute the query to decrement followers count
    $sql = "UPDATE users SET FOLLOWERS = FOLLOWERS - 1 WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $other_Person);
    $stmt->execute();
    $stmt->close();
}

?>
