<?php

/**
 * Created by PhpStorm.
 * User: rberthie
 * Date: 12/10/16
 * Time: 1:02 PM
 */
class Comment
{
    public $comment;
    public $user;
    public $pic_path;

    function __construct($info = NULL, $user = NULL)
    {
        if(isset($info) && isset($user) && isset($info['comment']['com_text']) && isset($info['comment']['pic_path']))
        {
            $this->comment = htmlentities($info['comment']['com_text']);
            $this->user = $user;
            $this->pic_path = htmlentities($info['comment']['pic_path']);
        }
    }

    public function AddCommToDb($db)
    {
        if(isset($this->comment) && isset($this->user) && isset($this->pic_path))
        {
            $db->query("INSERT INTO comment SET pict_name = ?, comment_user = ?, comment = ?", [
                $this->pic_path,
                $this->user,
                $this->comment
            ]);
        }
    }

    public function DisplayComm($db, $pic = NULL)
    {
        if(!isset($this->pic_path))
        {
            $this->pic_path = $pic;
        }
        $res = $db->query("SELECT * FROM comment WHERE (pict_name =:pic)", ['pic' =>
            $this->pic_path
        ])->fetchAll();

        if($res)
        {
            foreach ($res as $v)
            {
                if($v->pict_name === $pic)
                {
                    echo "<p id='comment-form'>" . $v->comment_user . " post : ";
                    echo $v->comment . "</p>";
                }
            }
        }
    }
}