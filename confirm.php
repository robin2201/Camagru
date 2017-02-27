<?php

require 'inc/autoload.php';

$db = App::getDatabase();
$db->getPdo();

if(App::getAuth()->confirm($db, htmlentities($_GET['id']),
    htmlentities($_GET['token']),
    Session::getInstance()))
{
    Session::getInstance()->setFlash('sucess', "Votre compte a bien été validé");
    App::redirect('home.php');
}
else
{
    Session::getInstance()->setFlash('danger', "Ce token n'est plus valide");
    App::redirect('index.php');
}