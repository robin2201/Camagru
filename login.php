<?php
require_once 'inc/autoload.php';
$auth = App::getAuth();
$db = App::getDatabase();
$db->getPdo();
$auth->connectFromCookie($db);

if($auth->user())
{
    App::redirect('home.php');
}
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password']))
{
    $user = $auth->login($db, htmlentities($_POST['username']), htmlentities($_POST['password']), isset($_POST['remember']));
    $session = Session::getInstance();
    if($user)
    {
        $session->setFlash('success', 'Vous êtes maintenant connecté');
        App::redirect('home.php');
    }
    else
    {
        $session->setFlash('danger', 'Identifiant ou mot de passe incorrects');
        App::redirect('index.php');
    }
}

require 'inc/Header.php';
echo "</header>";

$form = new DisplayForm();
echo $form->DisplayLoginForm();
require 'inc/footer.php';