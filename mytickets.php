<?php
session_start();

$tickets = simplexml_load_file("xml/Supportticket1.xml");

$selected = $tickets->ticket->attributes()->number;

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

//view ticket



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" type="text/css" href="css/myticket.css">

</head>
<body>
<header>
    <nav role='navigation'>
        <div class="logo"></div>
        <div class="navigation-name"><a href="?profile"><?= $user_details['name'] ?></a></div>
        <div class="navigation">
            <a href="?support">Support</a>
            <a href="?mysupports">My Support tickets</a>
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

            if ($user_details['@attributes']['id'] == $t->attributes()->client) {
                ?>
                <tr>
                    <td><?= $t->attributes()->number ?></td>
                    <td><a href="viewticket.php?selected=<?=$t->attributes()->number?>"><?= $t->title ?></a></td>
                    <td><?= $t->attributes()->status ?></td>
                    <td><?= $t->date ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>