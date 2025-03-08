<?php

include('config.php');




$sql = "SELECT COUNT(*) as total_posts FROM Posts";

$stmt = $conn->prepare($sql);

$stmt->execute();

$stmt->bind_result($total_posts);

$stmt->store_result();

$stmt->fetch();





// that php ceil function return rounded numbers



$stmt = $conn->prepare("SELECT * FROM Posts ORDER BY Post_ID DESC  ;");

$stmt->execute();

$posts = $stmt->get_result();


?>