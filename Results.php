<?php  include('Results_Provider.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PixelCraft</title>
    <link rel="icon" href="assets/images/event_accepted_50px.png" type="image/icon type">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/profile-page.css">
    <link rel="stylesheet" href="assets/css/section.css">
    <link rel="stylesheet" href="assets/css/posting.css">
    <link rel="stylesheet" href="assets/css/right_col.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/discover.css">
    <link rel="stylesheet" href="assets/css/results.css">
  
    
</head>

<style>

.bgimg 
    {
      background-image: url('assets/images/login_request/cover.png');
      
      min-height: 100vh;
      
      background-position: center;
      background-attachment: fixed;
      background-size: cover;
    }
    body{
        color:white;
    }
    .nav>.active{
        color:red;
    }
</style>

<body>
<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
<iframe src="naviibar.html" style="border:none; width:100%; height:60px"></iframe>


<div class="container">


        <?php
        include('config.php');
        if (isset($_POST['find'])) {
            $search_input = $_POST['find'];
            $SQL = "SELECT * FROM posts WHERE Caption LIKE '%$search_input%' OR HashTags LIKE '%$search_input%';";
            $stmt = $conn->prepare($SQL);
            $stmt->execute();
            $posts = $stmt->get_result();
        } else {
            $search_input = "car";
            $stmt = $conn->prepare("SELECT * FROM posts WHERE Caption like ? OR HashTags like ? limit 12");
            $stmt->bind_param("ss", strval("%" . $search_input . "%"), strval("%" . $search_input . "%"));
            $stmt->execute();
            $posts = $stmt->get_result();
        }
        ?>
    <br><br><br>

    <h3>Search Results For <?php echo $search_input?><small ></small></h3><br>

    <ul class="nav nav-pills nav-justified">
        <li class="active"  ><a data-toggle="pill" class="text-danger" href="#home"><i class="icon fas fa-vote-yea fa-lg"></i>Posts</a></li>
        <li ><a  data-toggle="pill" href="#menu2" class="text-danger"><i class="icon fas fa-users fa-lg"></i>Profiles</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <main>
                <div class="discover-container">
                    <div class="gallery">
                        <?php foreach ($posts as $post) { ?>
                        <div class="gallery-items">
                        <a href="single-post.php?post_id=<?php echo $post['Post_ID'];?>" style="color: white" target="_blank">
                            <img src="<?php echo "assets/images/posts/" . $post['Img_Path']; ?>" alt="post" class="gallery-img">
                            <div class="gallery-item-info">
                                <ul>
                                    <li class="gallery-items-likes"><span class="hide-gallery-elements"><?php echo $post['Likes']; ?></span>
                                        <i class="icon fas fa-thumbs-up"></i>
                                    </li>
                                    <li class="gallery-items-likes"><span class="hide-gallery-elements">Opinions</span>
                                        <i class="icon fas fa-comment"></i>
                                    </li>
                                </ul>
                            </div>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </main>
        </div>

        <div id="menu2" class="tab-pane fade">
            <br>
            <ul class="list-group">
                <?php
                $users = find_Users($search_input);
                foreach ($users as $members) {
                    ?>
                    <div class="result-section">
                        <li class="list-group-item search-result-item">
                            <img src="<?php echo "assets/images/profiles/" . $members['IMAGE']; ?>" alt="profile-image">
                            <div class="profile_card" style="margin-left: 20px;">
                                <div>
                                    <p class="username"><?php echo $members['FULL_NAME']; ?></p>
                                    <p class="sub-text"><?php echo $members['USER_NAME']; ?></p>
                                </div>
                            </div>
                            <div class="search-result-item-button">
                                <form method="post" action="follower_acc.php">
                                    <input type="hidden" value="<?php echo $members['User_ID'] ?>" name="target_id">
                                    <button type="submit" class="btn btn-outline-primary">Visit Profile</button>
                                </form>
                            </div>
                        </li>
                        <br>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
                </div>
</body>
<script type="text/javascript">
    document.getElementById("logo-img").onclick = function () {
        location.href = "home.php";
    };
</script>
</html>
