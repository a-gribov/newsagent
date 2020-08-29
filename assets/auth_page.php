<?php
$title='NewsAgent | Вход';
$zan='Войдите';
if(isset($_POST['login'])){
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
	$sql=$db->query("SELECT 1 user_id FROM feed_users WHERE user_id='$user_id'"); 
	if (!$sql || $sql->num_rows == 0){
	$sql="SELECT pars_item_id FROM pars_item";
	$result = $db->query($sql);
	while ($row=$result->fetch_assoc()){
		$pars_item_id=$row['pars_item_id'];
		$sql = $db->query("INSERT INTO feed_users(`user_id`,`pars_item_id`) 
			VALUES ('$user_id', '$pars_item_id')");
	}
}$db->close();
echo'<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/index.php">';}
else{	
	$zan='Введены не верные данные';
	echo'<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=../index.php?auth">';
	}
}
?>
<link href="../styles/signin.css" rel="stylesheet">
  <body class="text-center">
    <form class="form-signin" name="form_signup" action="../index.php?auth" method="post">
  <h1 class="h3 mb-3 font-weight-normal"> <?=$zan?></h1>
  <label for="inputEmail" class="sr-only">Логин</label>
  <input id="inputEmail"  name="login" class="form-control" placeholder="Введите логин" required >
  <label for="inputPassword" class="sr-only">Пароль</label>
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Введите пароль" required>
   <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
  <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
</form>