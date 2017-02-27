<?php

/**
 * Class Auth
 * User: robin
 */

class Auth{

    private $options = [
        'restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page"
    ];
    private $session;
    private $mail;

    public function __construct($session, $options = [])
    {
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
        if(!$this->mail)
        {
            $this->mail =  "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . dirname($_SERVER["PHP_SELF"]);
        }
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function register($db, $username, $password, $email)
    {
        $password = $this->hashPassword($password);
        $token = Str::random(60);
        $db->query("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?", [
            $username,
            $password,
            $email,
            $token
        ]);
        $user_id = $db->lastInsertId();
        mail($email,
            'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\n
                ".$this->mail."/confirm.php?id=$user_id&token=$token");
    }

    public function confirm($db, $user_id, $token)
    {
        $user = $db->query('SELECT * FROM users WHERE id = ?', [
            $user_id]
        )->fetch();
        if($user && $user->confirmation_token === $token )
        {
            $db->query('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?', [
                $user_id]
            );
            $this->session->write('auth', $user);
            return true;
        }
        return false;
    }

    public function restrict()
    {
        if(!$this->session->read('auth'))
        {
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            header('Location: index.php');
            exit();
        }
    }

    public function user()
    {
        if(!$this->session->read('auth'))
        {
            return false;
        }
        return $this->session->read('auth');
    }

    public function connect($user)
    {
        $this->session->write('auth', $user);
    }

    public function connectFromCookie($db)
    {
        if(isset($_COOKIE['remember']) && !$this->user())
        {
            $remember_token = $_COOKIE['remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $user = $db->query('SELECT * FROM users WHERE id = ?', [
                $user_id]
            )->fetch();
            if($user)
            {
                $expected = $user_id . '==' . $user->remember_token . hash( "whirlpool", $user_id . '42Born2Code');
                if($expected === $remember_token)
                {
                    $this->connect($user);
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                }
                else
                {
                    setcookie('remember', null, -1);
                }
            }
            else
            {
                setcookie('remember', null, -1);
            }
        }
    }

    public function login($db, $username, $password, $remember = false)
    {
        $user = $db->query('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL', [
            'username' => $username]
        )->fetch();
        if(password_verify($password, $user->password))
        {
            $this->connect($user);
            if($remember)
            {
                $this->remember($db, $user->id);
            }
            return $user;
        }
        else
        {
            return false;
        }
    }

    public function remember($db, $user_id)
    {
        $remember_token = Str::random(250);
        $db->query('UPDATE users SET remember_token = ? WHERE id = ?', [
            $remember_token,
            $user_id
        ]);
        setcookie('remember', $user_id . '==' . $remember_token . hash( "whirlpool", $user_id . '42Born2Code'), time() + 60 * 60 * 24 * 7);

    }

    public function logout()
    {
        setcookie('remember', NULL, -1);
        $this->session->delete('auth');
        session_destroy();
    }

    public function resetPassword($db, $email)
    {
        $user = $db->query('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL', [
            $email]
        )->fetch();
        if($user)
        {
            $reset_token = Str::random(60);
            $db->query('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?', [
                $reset_token,
                $user->id]);
            mail($email,
                'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\n
                    ".$this->mail."/reset.php?id={$user->id}&token=$reset_token'></a>");
            return $user;
        }
        return false;
    }

    public function checkResetToken($db, $user_id, $token)
    {
        return $db->query('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [
            $user_id, $token]
        )->fetch();
    }

}