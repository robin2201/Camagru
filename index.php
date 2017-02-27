<?php

require_once 'inc/autoload.php';
require 'inc/Header.php';
$auth = App::getAuth();
$db = App::getDatabase();
$db->getPdo();
$auth->connectFromCookie($db);
$dbVerif = require 'config/setup.php';
$db->query($dbVerif);



if($auth->user())
{
    App::redirect('home.php');
}
else
{
    $form = new DisplayForm();
}


?>

    </header>

<?= $form->DisplayButtonLogReg();?>


<?php require 'inc/footer.php';?>