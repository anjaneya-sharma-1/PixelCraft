<?php
session_start();
include("config.php");

$user_id = $_SESSION['id'];
$fallowing_person = $_POST['fallow_person'];

// Insert follow record into the database
$sql = "INSERT INTO fallowing(User_ID, Other_user_id) VALUES ($user_id, $fallowing_person);";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Close the database connection
$conn->close();

// Update followers and following counts
update_Following($user_id);
update_Followers($fallowing_person);

// Update session data for following count
$_SESSION['fallowing'] = $_SESSION['fallowing'] + 1;

echo '<form id="redirectForm" method="post" action="follower_acc.php">
        <input type="hidden" value="' . $fallowing_person . '" name="target_id">
      </form>';

// JavaScript to automatically submit the form
echo '<script type="text/javascript">
        document.getElementById("redirectForm").submit();
      </script>';

// Functions for updating followers and following counts
function update_Following($user_id) {
    include("config.php");
    $sql = "UPDATE users SET FOLLOWING = FOLLOWING + 1 WHERE User_ID = $user_id;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function update_Followers($other_Person) {
    include("config.php");
    $sql = "UPDATE users SET FOLLOWERS = FOLLOWERS + 1 WHERE User_ID = $other_Person;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}
?>
