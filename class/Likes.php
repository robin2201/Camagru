<?php

/**
 * Created by PhpStorm.
 * User: rberthie
 * Date: 12/11/16
 * Time: 12:19 PM
 */
class Likes
{

    function CountLike($db, $path)
    {
        if(isset($path))
        {
            $path = htmlentities($path);
        }
        $ret = $db->query("SELECT COUNT(like_id) AS 'TAG_COUNT' FROM likePic WHERE pict_name = ?", [
            $path,
        ])->fetch();
        if($ret)
        {
            return $ret;
        }
        else
        {
            return FALSE;
        }
    }

    function AddLike($db, $user, $path)
    {
        if(isset($user) && isset($path))
        {
            $user = htmlentities($user);
            $path = htmlentities($path);
        }
        else
        {
            Session::getInstance()->setFlash('danger', 'Sorry An error Occured!');
            die();
        }
        $IfLikeExist = $db->query("SELECT * FROM likePic WHERE username = ? AND pict_name = ?", [
            $user,
            $path
        ])->fetch();
        if($IfLikeExist !== FALSE)
        {
            Session::getInstance()->setFlash('danger', 'You have already like this pic!');
        }
        else
        {
            $db->query("INSERT INTO likePic SET username = ?, pict_name = ?", [
               $user,
                $path
            ]);
        }
    }
}