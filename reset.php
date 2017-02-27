<?php

require 'inc/autoload.php';


//App::getAuth()->restrict();
$auth = App::getAuth();
$db = App::getDatabase();
$db->getPdo();
$user = $auth->user();


if(isset($_GET['id']) && isset($_GET['token']))
{
    $user = $auth->checkResetToken($db, htmlentities($_GET['id']), htmlentities($_GET['token']));
    if(!$user)
    {
        Session::getInstance()->setFlash('danger',"Ce token n'est pas valide");
        App::redirect('index.php');
    }
}
elseif(empty($_GET['id']) && empty($_GET['token']) && !empty(($_POST))) {
    $verification = new Verif($_POST);
    $verification->isConfirmed(htmlentities($_POST['password']));
    if (empty($verification->isValid())) {
        $password = $auth->hashPassword($_POST['password']);
        $db->query('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?', [
            $password,
            $user->id]);
        $auth->connect($user);
        Session::getInstance()->setFlash('success', 'Votre mot de passe a bien été modifié');
        App::redirect('home.php');
    }
}
else
{
    App::getAuth()->logout();
    App::redirect('register.php');
}

require 'inc/Header.php';
echo "</header>";

$form = new DisplayForm();

echo $form->DisplayResetForm($user);
require 'inc/footer.php';