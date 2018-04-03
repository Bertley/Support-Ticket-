<?php
session_start();
//logout
if(isset($_GET['logout'])){
    unset($_SESSION['logged_in_client']);
    session_destroy();
}

//my supports
if(isset($_GET['mysupports'])){
    exit(header("Location:mytickets.php"));
}

//my profile
if(isset($_GET['profile'])){
    exit(header("Location:client.php"));
}

if(isset($_SESSION['logged_in_client']) && ($_SESSION['logged_in_client']) == true){
    //json decode user details from session into an array
    $user_details = json_decode($_SESSION['user_details'], true);

} else{
    exit(header("Location:login.php"));
}
//ticket number
$id = time();
//datetime
$now = new DateTime();

//submit ticket
//$xml = '';
$errors = array();
if(isset($_POST['submit'])){
    $userid = $_POST['userId'];
    $status = $_POST['status'];
    $ticketnum = $_POST['ticketnum'];
    $date = $_POST['date'];
    $datetime = $_POST['datetime'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $message = $_POST['message'];

    if($category == ''){
        $errors[] = 'Please select a category';
    }
    if($title == ''){
        $errors[] = 'You dont have a title';
    }
    if($message == ''){
        $errors[] = 'We require a message to be able to help you';
    }
    if(count($errors) == 0){

        $xml = simplexml_load_file("xml/Supportticket1.xml");
        //add a new ticket to the tickets node
        $ticket = $xml->addChild("ticket");
        $ticket->addAttribute("number", "$ticketnum");
        $ticket->addAttribute("status","$status");
        $ticket->addAttribute("supportCat", "$category");
        $ticket->addAttribute("client", "$userid");
        $ticket->addChild("date","$date");
        $ticket->addChild("title", "$title");
        $xml_message = $ticket->addChild("message", "$message");
        $xml_message->addAttribute("userId", "$userid");
        $xml_message->addAttribute("datetime", "$datetime");
        $xml->asXML("xml/Supportticket1.xml");
    }
}

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
            <a href="">Support</a>
            <a href="?mysupports">My Support tickets</a>
            <a href="?logout">Logout</a>
        </div>
    </nav>
    <section class="profile">
        <div class="shared-content">
            <div class="section-head">
                <h3>Create A Support Ticket</h3>
            </div>
            <form id="contact-us" method="post" action="clientsupport.php">
                <div class="col-xs-6 wow animated slideInLeft" data-wow-delay=".5s">
                    <input type="hidden" name="userId" id="userId" required="required" value="<?= $user_details['@attributes']['id']?>"/>
                    <input type="hidden" name="status" id="status" required="required" value="on-going"/>
                    <input type="hidden" name="ticketnum" id="ticketnum" required="required" value="<?= $id ?>"/>
                    <input type="hidden" name="date" id="date" required="required" value="<?= $now->format('Y-m-d') ?>"/>
                    <input type="hidden" name="datetime" id="datetime" required="required" value="<?= $now->format('Y-m-d H:i:s') ?>"/>
                    <select class="form" name="category">
                        <option value="">--SELECT A CATEGORY--</option>
                        <option value="Something isn't Working">Something isn't Working</option>
                        <option value="General Feedback">General Feedback</option>
                        <option value="Spam or Abuse">Spam or Abuse</option>
                    </select>
                    <input type="text" name="title" id="title" required="required" class="form" placeholder="Title" />
                </div>
                <div class="col-xs-6 wow animated slideInRight" data-wow-delay=".5s">
                    <textarea name="message" id="message" class="form textarea"  placeholder="Message"></textarea>
                </div>
                <div class="relative fullwidth col-xs-12">
                    <button type="submit" id="submit" name="submit" class="form-btn semibold">Send Message</button>
                </div>
                <div class="clear"></div>
            </form>
        </div>
    </section>
</div>
</body>
</html>

