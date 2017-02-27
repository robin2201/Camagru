<?php
require'inc/autoload.php';
Session::getInstance();

if(!empty($_POST))
{
    $errors = array();
    $db = App::getDatabase();
    $db->getPdo();
    $VerifUser = new Verif($_POST);
    $VerifUser->isAlpha('username', "Votre pseudo n'est pas valide (alphanumérique)");
    if($VerifUser->isValid())
    {
        $VerifUser->isUniq('username', $db, 'users', 'Ce pseudo est déjà pris');
    }
    $VerifUser->isEmail('email', "Votre email n'est pas valide");
    if($VerifUser->isValid())
    {
        $VerifUser->isUniq('email', $db, 'users', 'Cet email est déjà utilisé pour un autre compte');
    }
    $VerifUser->isConfirmed('password', 'Vous devez rentrer un mot de passe valide');

    if($VerifUser->isValid())
    {

        App::getAuth()->register($db, htmlentities($_POST['username']), htmlentities($_POST['password']), htmlentities($_POST['email']));
        Session::getInstance()->setFlash('success', 'Un email de confirmation vous a été envoyé pour valider votre compte');
        App::redirect('login.php');
    }
    else
    {
        $errors = $VerifUser->getErrors();
    }


}
require 'inc/Header.php';
echo "</header>";

if(!empty($errors)): ?>
<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
        <?php foreach($errors as $error): ?>
           <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif;
$form = new DisplayForm();
echo $form->DisplayRegisterForm();

require 'inc/footer.php';
?>