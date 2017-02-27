<?php

$pages = array('home.php',
    'index.php',
    'forget.php',
    'gallery.php',
    'logout.php');

$a =  "<a href=";
$i = 2;

echo "<div class='nav_header'>";
echo "<h1 id='title'>";
if(isset($_SESSION['auth']))
{
    $a .= $pages[0];
}
else
{
    $a .= $pages[1];
}
echo $a . ">Camagru</a>";
echo "</h1>";
echo "<div id='line_title'></div>";
if(isset($_SESSION['auth']))
{
    echo "<ul style='text-decoration: none'>";
    while($pages[$i])
    {
        $tmp = substr($pages[$i], 0, -4);
        echo "<li><a href='{$pages[$i]}'>{$tmp}</a></li>";
        unset($tmp);
        $i++;
    }
    echo "<p>Hello {$_SESSION['auth']->username}</p>";
    echo "</div>";
}

