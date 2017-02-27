<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 11/20/16
 * Time: 6:44 PM
 */

require 'inc/autoload.php';

App::getAuth()->restrict();
$db = App::getDatabase();
$db->getPdo();

$dbVerif = require 'config/setup.php';
$db->query($dbVerif);
require 'inc/Header.php';
$form = new DisplayForm();
$pictureGallery = new pictApi($_SESSION['auth']->username);
$likePicture = new Likes();

if(isset($_POST) && isset($_POST['comment']))
{
    $comment = new Comment($_POST, $_SESSION['auth']->username);
    $comment->AddCommToDb($db);
    unset($_POST['comment']['com_text']);
    unset($_POST['comment']['pic_path']);
}



if(isset($_POST['like']) && isset($_POST['path']))
{
    $likePicture->AddLike($db, $_SESSION['auth']->username, $_POST['path']);
    unset($_POST['like']);
    unset($_POST['path']);
}



$test = $pictureGallery->CountPic($db);
foreach ($test as $key => $value){
    $totalPics = $value;
    $totalPics = intval($totalPics);
    break;
}
$PicPerPages = 6;

$nbPages = ceil($totalPics / $PicPerPages);
if (isset($_GET['p']))
{
    $cp = intval($_GET['p']);
}
else
{
    $cp = 1;
}


if ($cp > $nbPages)
{
    $cp = $nbPages;
}
if ($cp < 1)
{
    $cp = 1;
}
$first = ($cp - 1) * $PicPerPages;
$select = $db->query("SELECT * FROM pictures ORDER BY picture_id DESC LIMIT $first, $PicPerPages")->fetchAll();
echo "</header>";

echo "<div class=test>";
foreach ($select as $row)
{
    echo "<div class='GalleryPictures'>";
    echo $form->DisplayFormLike($row->username, $row->picture_path, $row->picture_date, $cp);
    if(!$comment)
    {
        $comment = new Comment();
    }
    $haveLike = $likePicture->CountLike($db, $row->picture_path);
    if($haveLike !== FALSE)
    {
        echo $form->DisplayLikes($haveLike);
    }
    $comment->DisplayComm($db, $row->picture_path);
    unset($comment);
    echo $form->DisplayFormAddComm($row->picture_path, $cp);
    echo "</div>";
}
echo "</div>";
?>
<div class="pagination">
  <a href="gallery.php?p=<?=($cp - 1)?>">«</a>
  <a href="gallery.php?p=<?=($cp + 1)?>">»</a>
</div>
<?php


