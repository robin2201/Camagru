<?php

/**
 * Created by PhpStorm.
 * User: rberthie
 * Date: 12/12/16
 * Time: 6:26 PM
 */

class DisplayForm
{

    private function SurroundWithDiv($IdDiv, $html)
    {
        $ret = "<div id='" . $IdDiv . "'>";
        $ret = $ret . $html . "</div>";
        return $ret;
    }

    public function DisplayFormLike($user, $path, $date, $page)
    {
        if(isset($user) && isset($path) && isset($date))
        {

            $ret  = "<p>" . $user . " Upload :" . $path . " At : " . $date . "</p>";
            $ret = $ret . "<img src='" . $path . "'/>";
            $ret = $ret . "<br>";

            $form = "<form method='post' action='gallery.php?p=$page'>";
            $form = $form . "<button type='submit' name='like'>Like</button>";
            $form = $form . "<input type='hidden' name='path' value='". $path ."'/>";
            $form = $form . "</form>";

            $ret = $ret . $form;
            return ($ret);
        }


    }


    public function DisplayFormAddComm($pic, $page)
    {
        if(isset($pic))
        {
            $ret = ("<div>
                    <form method='post' action='gallery.php?p=$page'>
                        <label>Ajouter un commentaire !</label>
                        <textarea name='comment[com_text]' required></textarea>
                        <input type='hidden' name='comment[pic_path]' value='" . $pic ."'>
                        <button type='submit'>Send!</button>
                    </form>
                </div>");
            return $ret;
        }
    }

    public function DisplayLoginForm()
    {
        $ret = "<h2>Log In</h2>";
        $ret = $ret . ("<form method='post' action='login.php'>
                            <label>Pseudo or Email</label>
                            <input type='text' name='username' required>
                            <label>Password <a href='forget.php'>(J'ai oublié mon mot de passe)</a> </label>
                            <input type='password' name='password' required>
                            <label>Remember Me!
                            <input type='checkbox' name='remember' value='1'>
                            </label>
                            <button type='submit'>Submit</button>
                        </form>
    ");
        $ret = $this->SurroundWithDiv('LoginForm', $ret);
        return $ret;
    }


    public function DisplayRegisterForm()
    {
        $ret = "<h2>Register</h2>";
        $ret = $ret . ("<form method='post' action='register.php'>
                        <label>Pseudo</label>
                        <input type='text' name='username' required>
                        <label>Email</label>
                        <input type='text' name='email' required>
                        <label>Password</label>
                        <input type='password' name='password' required>
                        <label>Confirm Password</label>
                        <input type='password' name='password_confirm' required/>
                        <button type='submit'>Submit</button>
                      </form>
    ");
        $ret = $this->SurroundWithDiv('RegisterForm', $ret);
        return $ret;
    }


    public function DisplayLikes($likes)
    {
        foreach ($likes as $like)
        {
            $like = intval($like);

        }
        if($like !== 0)
        {
            $ret = $this->SurroundWithDiv('like-control', $like);
            return $ret;
        }
    }

    public function DisplayButtonLogReg()
    {
        $ret = ("
                    <p><a id='ButtonRegister' href='register.php'>Register</a></p>
                    <p><a id='ButtonLogin' href='login.php'>Login</a></p>
        ");
        $ret = $this->SurroundWithDiv('ButtonIndex', $ret);
        return $ret;
    }

    public function DisplayMailInstructionReset()
    {
        $ret = ("<h3>Mot de Passe Oublié!</h3>
                    <form action='forget.php' method='post'>
                        <label>Email</label>
                        <input type='email' name='email' required>
                        <button type='submit'>Send Reset informations</button>
                    </form>
        ");
        $ret = $this->SurroundWithDiv('FormMailReset', $ret);
        return $ret;
    }

    public function DisplayResetForm()
    {
        $ret = ("<h1>Reset Your Password</h1>
            <form action='reset.php' method='post'>
                <label>Mot de passe</label>
                <input type='password' name='password' required>    
                <label>Confirmation du mot de passe</label>
                <input type='password' name='password_confirm' required>
                <button type='submit'>Send</button>
             </form>
        ");
        $ret = $this->SurroundWithDiv('ResetForm', $ret);
        return $ret;
    }

    function DisplayUploadPicture()
    {
        $ret = ("<form action='home.php' method='post' enctype='multipart/form-data'>
                    <label>Upload Your Pic</label>
                    <input type='file' name='PicUpload'>
                    <button type='submit'>Submit</button>
                </form>
        ");
        $ret = $this->SurroundWithDiv('UploadForm', $ret);
        return $ret;
    }


    function DisplayChoicePicHome()
    {
        $ret = ("<h2>Que voulez vous faire?</h2>
                 <a href='home.php?U=u'>Upload</a>
                 <a href='home.php?W=w'>Webcam</a>
        ");
        $ret = $this->SurroundWithDiv('choice', $ret);
        return $ret;
    }

}