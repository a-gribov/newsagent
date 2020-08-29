<?php
$title='NewsAgent | Регистрация';
$zan='Пожалуйста, зарегистрируйтесь';

if ((isset($_POST['login']))&&(isset($_POST['password'])))


{
$login=$_POST['login'];
$pass=$_POST['password'];
require_once 'connection.php'; 
$sql=$db->query("SELECT 1 login FROM users WHERE login='$login'"); 
	if (!$sql || $sql->num_rows == 0) 
{
	$sql=$db->query("INSERT INTO users (`login`, `pass`) VALUES ('$login', '$pass')");	

	if ($sql)
{
echo'<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../index.php?auth">';
}

}

else
{
  echo'<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=../index.php?reg">';
$zan='логин занят!';
}




$db->close();
}
?>

<link href="../styles/signin.css" rel="stylesheet">
  <body class="text-center">


    <form class="form-signin" name="form_signup" action="../index.php?reg" method="post">
  <h1 class="h3 mb-3 font-weight-normal">  <?=$zan?></h1>

  <label for="inputEmail" class="sr-only">Логин</label>
  <input id="inputEmail" autocomplete="off" name="login" class="form-control" placeholder="Введите логин" required >
  <label for="inputPassword" class="sr-only">Пароль</label>
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Введите пароль" autocomplete="off" required>
   <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
  <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
</form>



