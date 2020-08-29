<?php
require 'connection.php';
$id=$_GET['id'];
if (!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else{
    $ip = $_SERVER['REMOTE_ADDR'];
}
$sql_1=$db->query("SELECT news_url FROM news WHERE news_id='$id'"); 
$row_1 = mysqli_fetch_assoc($sql_1);
$url=$row_1['news_url'];
    $sql=$db->query("SELECT * FROM url_ip WHERE news_id='$id' and ip='$ip'"); 
$row = mysqli_fetch_array($sql);
$ip_bd=$row['ip'];
 if ($ip != $ip_bd)
{	$sql = $db->query("INSERT INTO url_ip (`news_id`,`ip`)VALUES ('$id','$ip')"); 
	$sql = $db->query("UPDATE `news` SET views = views +1 WHERE news_id = '$id'");
}
$db->close();
header('Location:'.$url);
