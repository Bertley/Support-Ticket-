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

//my profile
if(isset($_GET['profile'])){
    exit(header("Location:client.php"));
}

//my supports
if(isset($_GET['mysupports'])){
    exit(header("Location:mytickets.php"));
}

$selection = $_GET['selected'];

$tickets = simplexml_load_file("xml/Supportticket1.xml");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="css/ticket.css">
</head>
<body>
<div class="body">
    <nav role='navigation'>
        <div class="logo"></div>
        <div class="navigation-name"><a href="?profile"><?= $user_details['name'] ?></a></div>
        <div class="navigation">
            <a href="?support">Support</a>
            <a href="?mysupports">My Support tickets</a>
            <a href="?logout">Logout</a>
        </div>
    </nav>
    <section class="profile">
        <div class="shared-content">
            <div class="section-head">
                <h3>Ticket Details</h3>
            </div>
            <?php
                foreach ($tickets->ticket as $t) {
                    if($selection == $t->attributes()->number){
                        ?>
                            <p>Ticket Number : <?= $t->attributes()->number ?></p>
                            <p>Status : <?=$t->attributes()->status ?></p>
                            <p>Category : <?=$t->attributes()->supportCat ?></p>
                            <p>Date of Issue : <?= $t->date ?></p>
                            <p>Title: <?= $t->title ?></p>
                            <p>Message: <?php if($t->message->attributes()->userId == $user_details['@attributes']['id']){
                                echo $t->message;
                                } ?></p>
                            <p>Response: <?php if($t->message->attributes()->userId !== $user_details['@attributes']['id']){
                                    echo $t->response;
                                }?></p>
                        <?php
                    }
                }
            ?>
        </div>
    </section>
</div>
</body>
</html>
