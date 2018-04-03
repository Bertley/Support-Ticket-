<?php
session_start();
//logout
if(isset($_GET['logout'])){
    unset($_SESSION['logged_in_client']);
    session_destroy();
}

if(isset($_SESSION['logged_in_client']) && ($_SESSION['logged_in_client']) == true){
    //json decode user details from session into an array
    $user_details = json_decode($_SESSION['user_details'], true);

} else{
    exit(header("Location:login.php"));
}

//support
if(isset($_GET['support'])){
    exit(header("Location:clientsupport.php"));
}

//my supports
if(isset($_GET['mysupports'])){
    exit(header("Location:mytickets.php"));
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body>
    <div class="body">
        <nav role='navigation'>
            <div class="logo"></div>
            <div class="navigation-name"><?= $user_details['name'] ?></div>
            <div class="navigation">
                <a href="?support">Support</a>
                <a href="?mysupports">My Support tickets</a>
                <a href="?logout">Logout</a>
            </div>
        </nav>
        <section class="profile">
            <div class="social">
                <a href="#">My Profile</a>
                <div class="following">
                    <div class="number">42</div>
                    <div class="label">Following</div>
                </div>
                <div class="followers">
                    <div class="number">23</div>
                    <div class="label">Followers</div>
                </div>
            </div>
            <div class="shared-content">
                <div class="section-head">
                    <h3>Codes</h3>
                    <a href="#">Add</a>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="title">How to Bounce Shapes</div>
                        <div class="author"><?= $user_details['name'] ?></div>
                        <div class="preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, soluta vitae blanditiis neque tempore eaque. Vero repudiandae hic sapiente. Molestias repudiandae numquam, maxime fugiat ea libero ducimus tenetur sunt facere.</div>
                    </div>
                </div>
        </section>
    </div>
</body>
</html>

