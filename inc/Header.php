<?php Session::getInstance();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Camagru</title>

    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>

    <link href="public/css/style.css?v=<?=time();?>" rel="stylesheet">
    <link href="public/css/animation.css?v=<?=time();?>" rel="stylesheet">
</head>

<body>


<div class="container">
<header>
    <div id="logo">
        <img src="public/fonts/logo.svg">
    </div>
    <?php


    require "nav.php";

    if(Session::getInstance()->hasFlashes())
    {
    foreach(Session::getInstance()->getFlashes() as $t => $mess)
    {
    echo ("<div class='alert alert-" . $t . "'>"
        . $mess . "
    </div>
    ");
    }
    }

    ?>



