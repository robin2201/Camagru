<?php

/**
 * Created by PhpStorm.
 * User: robin
 * Date: 11/20/16
 * Time: 7:04 PM
 */

require 'inc/autoload.php';

if(!empty($_POST['email']))
{
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $db = App::getDatabase();
        $db->getPdo();
        $auth = App::getAuth();
        if($auth->resetPassword($db, htmlentities($_POST['email'])))
        {
            Session::getInstance()->setFlash('success', 'Les instructions du rappel de mot de passe vous ont été envoyées par emails');
            App::redirect('home.php');
        }
        else
        {
            Session::getInstance()->setFlash('danger', 'Aucun compte ne correspond à cette adresse mail');
        }
    }
}

require 'inc/Header.php';
echo "</header>";


$form = new DisplayForm();
echo $form->DisplayMailInstructionReset();
require 'inc/footer.php';
