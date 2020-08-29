<?php
error_reporting(E_ALL);
header("refresh:360;");

include 'assets/controller.php';
include 'assets/header.php';

if(isset($_GET['cat_id'])){include  'assets/content.php';}
elseif(isset($_GET['feed'])){include    'assets/feed.php';}
elseif( ((!empty($_SESSION['status']))&&($_SESSION['status'] == 1))&&(isset($_GET['admin']))){include 'assets/admin/adminka.php';}
elseif(isset($_GET['search'])){include  'assets/search.php';}
elseif(isset($_GET['reg'])){include 'assets/reg_page.php';}
elseif(isset($_GET['auth'])){include    'assets/auth_page.php';}
elseif(isset($_GET['auth_script'])){include 'assets/auth_script.php';}
elseif(isset($_GET['about'])){include 'assets/about.php';}
else{include    'assets/content.php';}
echo '<title>'.$title.'</title>'
?>