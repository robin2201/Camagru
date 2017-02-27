<?php
require 'inc/autoload.php';
App::getAuth()->logout();
Session::getInstance()->setFlash('success', 'Vous êtes maintenant déconnecté');
App::redirect('index.php');