<?php

include("config.php");

session_start();

if(!isset($_SESSION['id']))
{
  header('location: login.php');

  exit;
}

?>

<?php if(isset($_GET['error_message'])){ ?>

    <?php

    $message = $_GET['error_message'];

    echo"<body onload='notification_function(`Error Message`, `$message`, `#da1857`);'</body>"

    ?>

<?php }?>

<?php if(isset($_GET['success_message'])){ ?>

    <?php

    $message = $_GET['success_message'];

    echo"<body onload='notification_function(`Success Message`, `$message`, `#0F73FA`);'</body>"

    ?>
