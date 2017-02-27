<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 11/20/16
 * Time: 6:10 PM
 */


require 'inc/autoload.php';
App::getAuth()->restrict();
//Session::getInstance();

require 'inc/Header.php';
$form = new DisplayForm();

$db = App::getDatabase();
$db->getPdo();
$dbVerif = require 'config/setup.php';
$db->query($dbVerif);




$picture = new PictApi($_SESSION['auth']->username);

if(!empty($_POST) || isset($FILES))
{
    $havePng = 0;
    $bool = 0;
    if(isset($_POST['pics']))
    {
        $picture->BuildImage($_POST['pics']);
        if(isset($_SESSION['picture']))
        {
            unset($_SESSION['picture']);
        }
        $bool = 1;
    }
    else if (isset($_FILES["PicUpload"]))
    {
        $picture->UploadPic($_FILES["PicUpload"]["tmp_name"],
            $_FILES["PicUpload"]["size"],
            $_FILES["PicUpload"]["name"]
        );
        $bool = 1;
    }
    if ($picture->getPic())
    {
        $_SESSION['picture'] = $picture->getPic();
    }
    if(isset($_POST['alpha']) && isset($_SESSION['picture']))
    {
        $picture->AddPng($_POST['alpha'], $_SESSION['picture']);
        unset($_POST['alpha']);
        unset($_SESSION['picture']);
        $picture->AddPicToDb($db);
      //  $havePng = 1;
    }
    //if($bool === 1 && $havePng === 1)
    //{
//        $picture->AddPicToDb($db);
    //}
}

if(isset($picture))
{
    $mypic = $picture->DisplayGalleryUser($db);
}


if(isset($_POST) && $_POST['delete_pic'])
{
    $tmp_pic = htmlentities($_POST['delete_pic']);
    if (file_exists($_POST['delete_pic']))
    {
        $picture->DeletePic($db, $tmp_pic, $_SESSION['auth']->username);
        unlink($_POST['delete_pic']);
        unset($_POST['delete_pic']);
        $mypic = $picture->DisplayGalleryUser($db);
    }
    else
    {
        echo "Sorry this pic doesn't exist anymore !";
    }
}

?>
    </header>
<?php
echo $form->DisplayChoicePicHome();
echo "    <div class=\"home\">";
if (!empty($_GET) && $_GET['U'] === 'u')
{
    echo $form->DisplayUploadPicture();
}
elseif (!empty($_GET) && $_GET['W'] === 'w')
{
    ?>
    <video id="video"></video>
    <button id="startbutton">Prendre une photo</button>
    <canvas style="display: none" id="canvas"></canvas>
    <script type="text/javascript" src="public/js/cam.js"></script>
    <?php
}
?>

    <div class="png">
        <h2>My png</h2>
        <form method="post" action="#">
                <div class="selectionPng">
                    <?php

                    if(is_dir('png'))
                    {
                        if ($handle = opendir('png/'))
                        {
                            while (false !== ($entry = readdir($handle)))
                            {
                                if ($entry !== "." && $entry !== "..")
                                {
                                    ?>
                                    <img class="pngImg" style="width: 50px;" src="png/<?= $entry; ?>"><input type="radio" name="alpha" value="<?= $entry ?>">
                                    <?php
                                }
                            }
                            closedir($handle);
                        }
                    }
                    ?>
                </div>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    </div>

        <h2>My gallery</h2>
    <div class="my_gallery">
        <?php

         if(isset($mypic))
         {

                foreach ($mypic as $res)
                {?>
                    <div class="myElem">
                    <img src="<?= $res->picture_path;?>">
                    <form method="post" action="home.php">

                                <input type="radio" name="delete_pic" value="<?=$res->picture_path?>">
                            <button type="submit" onclick="window.refresh();">Delete</button>
                    </form>
                    </div>
                    <?php
                }
         }
            ?>
    </div>

<?php require 'inc/footer.php';?>