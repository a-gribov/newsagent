<?php
$login=$_POST['login'];
$pass=$_POST['password'];
$sql="SELECT * FROM users WHERE login='$login' AND BINARY pass='$pass'";
$result = $db->query($sql);
	if ($result->num_rows){
$_SESSION['login']=$login;
$row=$result->fetch_assoc();
$user_id=$row['user_id'];
$_SESSION['status']=$row['status'];
$_SESSION['user_id']=$row['user_id'];
	$sql="SELECT pars_item.pars_item_id	FROM pars_item 	LEFT JOIN feed_users  ON pars_item.pars_item_id = feed_users.pars_item_id
	AND feed_users.user_id='$user_id'	WHERE feed_users.pars_item_id is NULL";
	$result = $db->query($sql);
	while ($row=$result->fetch_assoc())	{
		$pars_item_id=$row['pars_item_id'];
		$sql = $db->query("INSERT INTO feed_users(`user_id`,`pars_item_id`)	VALUES ('$user_id', '$pars_item_id')");
	}$db->close();
echo'<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/index.php">';}
else
{echo'<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/index.php?auth">';}






