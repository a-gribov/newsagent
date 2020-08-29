<?php
$host = 'localhost';
$database = 'pars';
$user = 'root';
$password = 'root';
$db = new mysqli($host, $user, $password, $database)or die("Ошибка " . mysqli_error($db));
$db->set_charset('utf8');