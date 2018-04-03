<?php
session_start();

$tickets = simplexml_load_file("xml/Supportticket1.xml");

$selected = $tickets->ticket->attributes()->number;

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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="css/myticket.css">
</head>
<div class="bg"></div>
<body>
<header>
    <nav role='navigation'>
        <div class="logo"></div>
        <div class="navigation-name"><?= $user_details['name'] ?></div>
        <div class="navigation">
            <a href="?logout">Logout</a>
        </div>
    </nav>
</header>

<table>
    <caption>Support Tickets</caption>
    <thead>
    <tr>
        <th scope="col">Number</th>
        <th scope="col">Title</th>
        <th scope="col">Status</th>
        <th scope="col">date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($tickets->ticket as $t) {

            ?>
            <tr>
                <td><?= $t->attributes()->number ?></td>
                <td><a href="adminticket.php?selected=<?=$t->attributes()->number?>"><?= $t->title ?></a></td>
                <td><?= $t->attributes()->status ?></td>
                <td><?= $t->date ?></td>
            </tr>

            <?php

    }
    ?>
    </tbody>
</table>
</body>
</html>