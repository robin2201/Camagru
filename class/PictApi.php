<?php

/**
 * Created by PhpStorm.
 * User: rberthie
 * Date: 11/30/16
 * Time: 10:19 AM
 */

class PictApi
{
    public $picture;
    public $png;
    public $username;
    public $imgPng;
    private $uid;
    private $pic_path;
    private $table;
    public $uploadOk;

    private $image_dir = "images/";
    private $upload_dir = "uploads/";

    function __construct($user)
    {
        if (!file_exists($this->image_dir))
        {
            mkdir($this->image_dir);
        }
        $this->username = $user;
        $this->uid = uniqid();
        $this->table = "pictures";
        $this->uploadOk = 1;
    }

    public function getPic()
    {
        if (isset($this->pic_path))
        {
            return $this->pic_path;
        }
    }

    public function BuildImage($picture)
    {
        if (isset($picture))
        {
            $this->picture = $picture;

        }

        $this->pic_path = $this->image_dir . $this->uid . ".png";
        $this->picture = str_replace('data:image/png;base64,', '', $this->picture);
        $this->picture = str_replace(' ', '+', $this->picture);
        $this->picture = base64_decode($this->picture);
        file_put_contents($this->pic_path , $this->picture);
    }


    public function AddPng ($png, $pic = NULL)
    {
        if (isset($png))
        {
            $this->png = $png;
        }
        if(!isset($this->pic_path))
        {
            $this->pic_path = $pic;
        }
        $ext = pathinfo($this->pic_path, PATHINFO_EXTENSION);
        if($ext === "png")
        {
            $img = imagecreatefrompng($this->pic_path);
        }
        else
        {
            $img = imagecreatefromjpeg($this->pic_path);
        }
        unset($ext);
        $ext = pathinfo('png/'. $this->png, PATHINFO_EXTENSION);
        if($ext === "png")
        {
            $alpha = imagecreatefrompng(('png/'. $this->png));
        }
        else
        {
            $alpha = imagecreatefromjpeg(('png/'. $this->png));
        }
        $destx = imagesx($alpha);
        $desty = imagesy($alpha);
        $cut = imagecreatetruecolor($destx, $desty);
        imagecopy($cut, $img, 0, 0, 0, 0, $destx, $desty);
        imagecopy($cut, $alpha, 0, 0, 0, 0, $destx, $desty);
        imagecopymerge($img, $cut, 0, 0, 0, 0, $destx, $desty, 100);
        imagepng($img, $this->pic_path);
        imagedestroy($img);
    }

    public function AddPicToDb ($db, $username = NULL, $pic_path = NULL)
    {
        if(!isset($username) && !isset($pic_path))
        $db->query("INSERT INTO pictures SET username = ?, picture_path = ?, picture_date = NOW()", [
            $this->username,
            $this->pic_path
        ]);
        else
        {
            $db->query("INSERT INTO pictures SET username = ?, picture_path = ?, picture_date = NOW()", [
                $username,
                $pic_path
            ]);
        }
    }

    public function DisplayGalleryUser($db)
    {
        $req = $db->query("SELECT * FROM pictures WHERE username = ?", [$this->username]);
        return ($req);
    }

    public function GetAllPic ($db)
    {
        $req = $db->query("SELECT * FROM $this->table ORDER BY picture_id DESC");
        return $req;
    }

    public function DeletePic ($db, $picture_pat, $user)
    {
        $db->query("DELETE FROM `pictures` WHERE picture_path = ? AND username = ?", [$picture_pat, $user]);
    }


    public function UploadPic ($pic_data, $pic_size, $pic_name)
    {

        if(!file_exists($this->upload_dir))
        {
            mkdir($this->upload_dir);
        }

        if (isset($pic_data))
        {
            $this->picture = $pic_data;
        }

        $imageFileType = pathinfo($pic_name, PATHINFO_EXTENSION);

        $this->pic_path = $this->upload_dir . $this->uid . "." .$imageFileType;
        $check_pic = getimagesize($this->picture);
        if($check_pic !== FALSE)
        {
            if(!file_exists($this->pic_path))
            {
                if($pic_size < 500000)
                {
                    if($imageFileType === "jpg" || $imageFileType === "jpeg" || $imageFileType === "png")
                    {
                        $this->uploadOk = 0;
                    }
                }
            }
        }

        if($this->uploadOk === 0)
        {
            if(move_uploaded_file($this->picture, $this->pic_path))
            {
                echo "The file has been uploaded.";
            }
        }
        else
        {
            echo "Error, it's not possible to Upload this file";
        }
    }

    public function CountPic($db)
    {
        $ret = $db->query("SELECT COUNT(picture_id) AS 'PICS' FROM pictures")->fetch();
        if($ret)
        {
            return $ret;
        }
    }
}