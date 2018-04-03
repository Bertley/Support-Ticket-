<?php
session_start();

$mydata = simplexml_load_file("xml/Users.xml");

$username = "";
$password = "";
$role = "";
$name = "";

for($i = 0; $i < count($mydata); $i++) {
    $username = $mydata->user[$i]->email;
    $password = $mydata->user[$i]->password;
    $role = $mydata->user[$i]->attributes()->role;
    $name = $mydata->user[$i]->name;

    //echo $role;

    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $_SESSION['error'] = 'Please fill in both username and password';
        exit(header("Location:login.php"));
    }

    if(($_POST["username"] == $username) && ($_POST["password"] == $password) && ($role == "staff"))
    {
        //set logged in
        $_SESSION['logged_in_admin'] = true;
        //unset password
        unset($mydata->user[$i]->password);
        //JSON encode the user stuff from the xml
        $_SESSION['user_details'] = json_encode($mydata->user[$i]);
        //goto admin
        exit(header("Location:admin.php"));
    }

    if (($_POST["username"] == $username) && ($_POST["password"] == $password) && ($role == "client"))
    {
        //set logged in
        $_SESSION['logged_in_client'] = true;
        //unset password
        unset($mydata->user[$i]->password);
        //JSON encode the user stuff from the xml
        $_SESSION['user_details'] = json_encode($mydata->user[$i]);
        //goto client
        exit(header("Location:client.php"));
    }
}

$_SESSION['error'] = 'Invalid username and password';
exit(header("Location:login.php"));