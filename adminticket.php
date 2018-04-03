<?php
session_start();
//logout
if(isset($_GET['logout'])){
    unset($_SESSION['logged_in_admin']);
    session_destroy();
}

if(isset($_SESSION['logged_in_admin']) && ($_SESSION['logged_in_admin']) == true){
    //json decode user details from session into an array
    $user_details = json_decode($_SESSION['user_details'], true);

} else{
    exit(header("Location:login.php"));
}

if(isset($_GET['profile'])){
    exit(header("Location:client.php"));
}

$selection = $_GET['selected'];

$tickets = simplexml_load_file("xml/Supportticket1.xml");

//ticket number
$id = time();
//datetime
$now = new DateTime();

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
               if ($selection == $t->attributes()->number){
                    ?>
                    <p>Ticket Number : <?= $t->attributes()->number ?></p>
                    <p>Status : <?=$t->attributes()->status ?></p>
                    <p>Category : <?=$t->attributes()->supportCat ?></p>
                    <p>Date of Issue : <?= $t->date ?></p>
                    <p>Title: <?= $t->title ?></p>
                    <p>Message: <?= $t->message ?></p>
                   <p>Support: <?= $t->response ?></p>
                   <?php

                   if($t->response == ""){
                      ?>
                       <form method="post" action="" enctype="multipart/form-data" autocomplete="off">
                           <textarea name="message" id="message" class="form textarea"  placeholder="Message"></textarea>
                           <button type="submit" name="submit">Respond</button>
                           <input type="hidden" name="userId" id="userId" required="required" value="<?= $user_details['@attributes']['id']?>"/>
                           <input type="hidden" name="datetime" id="datetime" required="required" value="<?= $now->format('Y-m-d H:i:s') ?>"/>

                       </form>
                       <?php
                   } else {
                       echo "";
                   }
                   ?>

                    <?php

                    if(isset($_POST['submit'])){
                        $response = $_POST['message'];
                        $userid = $_POST['userId'];
                        $datetime = $_POST['datetime'];

                        $t->attributes()->status = "resolved";
                        $response_message = $t->addChild("response","$response");
                        $response_message->addAttribute("userId", "$userid");
                        $response_message->addAttribute("datetime", "$datetime");
                        $tickets->asXML("xml/Supportticket1.xml");


                    }
                }
            }
            ?>
        </div>
    </section>
</div>
</body>
</html>
