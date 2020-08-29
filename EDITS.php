1 Мульти выбор источников на главной для авторизованных 

//PARSER
<?php
error_reporting(E_ALL);
require 'assets/connection.php';
$sql_sel_pars_item = ("SELECT * FROM pars_item WHERE allow_pars=1"); 
if($result = $db->query($sql_sel_pars_item)) 
{
while (($row_sspi = $result->fetch_assoc()) != false) 
{
	$source=$row_sspi['pars_item_id'];
	$url=$row_sspi['url'];
		parser_rss($url,$source);
}
}
$result->free();
function parser_rss($url,$source)
{	
require_once 'phpQuery/phpQuery.php';
require 'assets/connection.php';
$file = file_get_contents($url);
$doc = phpQuery::newDocument($file);
    foreach($doc->find('item') as $article)
{
		$article = pq($article);
		$cat=trim($article->find('category')->text());
		$cat=mb_convert_case($cat, MB_CASE_TITLE, "UTF-8");
		
		$news_url =$article->find('link:eq(0)')->text();
		$zag = trim($article->find('title')->text());
		$datetime= $article->find('pubDate')->text();
		$datetime = date('Y-m-d G:i:s',strtotime($datetime));
		$time=date('G:i:s',strtotime($datetime));
		$date=date('Y-m-d',strtotime($datetime));

		if (empty($cat))
		{
			$cat='В мире';
		}
$sql=$db->query("SELECT 1 category FROM category WHERE category='$cat'"); 
	if (!$sql || $sql->num_rows == 0) 
{
$sql= $db->query("INSERT INTO category (`category_id`, `category`) VALUES('','$cat')");
}

$sql = ("SELECT category_id FROM category WHERE category='$cat'"); 
if($result = $db->query($sql)) 
{
while (($row = $result->fetch_assoc()) != false) 
{
	$cat=$row['category_id'];
}
}
$sql=$db->query("SELECT 1 zag FROM news WHERE zag='$zag'"); 
if (!$sql || $sql->num_rows == 0) 
{
$sql = $db->query("INSERT INTO news (`news_id`,`pars_item_id`,`news_url`,`category_id`, `zag`,`datetime`,`time`, `date`) 
VALUES ('', '$source','$news_url','$cat', '$zag', '$datetime', '$time','$date')");
}
}
phpQuery::unloadDocuments();
}
$db->close();//



1//Админка с графиком
1//И также через админку добавлять и удалять источники через БД 



01аналитика новостей

1*на главной авторизацию
11111111фильтр по времени: за последний час, за три часа, за сутки.
1настроить чтобы с одного ip не увеличивались просмотры более 1 раза
// записать ип в таблицу к определенной новости и сравнивать каждый раз 
// если такой есть
//  то не делаем просмотры больше одного, один раз оно выполнится
//  делаем переменную, сравниваем по бд с полем ип у новости, если есть то просто открываем сайт,
//  если нету ип такого то заисываем прсомотры.

/// страница топ-все-кат
<?php
setlocale(LC_ALL, 'ru_RU.UTF-8');
if (isset ($_SESSION['user_id']))			
{
	$feed_users=",feed_users.read_notread";
	$lft_jn_prs_itm="LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id";
	$left_join_where_feed="LEFT JOIN feed_users ON feed_users.pars_item_id=news.pars_item_id WHERE feed_users.user_id='{$_SESSION['user_id']}' and feed_users.read_notread=1";
	$sql_cat=("SELECT category.category_id,category.category $feed_users FROM category,news	$lft_jn_prs_itm $left_join_where_feed
  and views>=1 and news.category_id = category.category_id GROUP BY category ORDER BY SUM(views) DESC LIMIT 22 ");//блок с категориями
}
else 
{	
	$feed_users='';
	$lft_jn_prs_itm='';
	$left_join_where_feed='';
	$sql_cat=("SELECT category.category_id,category.category FROM category,news	
  WHERE views>=1 and news.category_id = category.category_id GROUP BY category ORDER BY SUM(views) DESC LIMIT 22 ");//блок с категориями
}

$sql_top=("SELECT news.news_id, news.datetime, news.time, news.zag, category.category,news.views,pars_item.source $feed_users FROM news 
LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
LEFT JOIN category ON category.category_id=news.category_id $left_join_where_feed ORDER BY views DESC LIMIT 7 ");//блок с топ новостями

$sql = ("SELECT news.news_id, news.datetime,news.time,news.zag,category.category,news.views,pars_item.source $feed_users FROM news 
	LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
	LEFT JOIN category ON category.category_id=news.category_id $left_join_where_feed ORDER BY news.datetime DESC LIMIT 9");//блок с последними новостями

echo"
<div class='container mt-2 p-3'>
<div class='row mt-3 align-items-start'>";

echo"
<div class='col-lg-3 mb-5 col-12 mx-auto shadow p-3 bg-dark text-light rounded'>ПОПУЛЯРНОЕ<HR>
";

if($result_top = $db->query($sql_top)) 
{
    if($result_top->num_rows > 0) 
    {
		while($row_top = $result_top->fetch_array())
{
$datetime_top =$row_top['datetime'];
$date_top= strftime(' %d %b', strtotime($datetime_top));
$time_top=$row_top['time'];
$time_top= date(' H:i', strtotime($time_top));
	echo"
<div class='col-md-12 col-12 mx-auto mb-3 shadow p-1 bg-light text-dark rounded'>
<a class= 'h5 text-dark stretched-link' href=\"../assets/linkcounter.php?id={$row_top['news_id']}\" target=\"_blank\">".$row_top['zag']."</a>
		<div class='row p-1  align-items-end'>
				<div class='fz10 col-4 col-sm-4 '>
".$row_top['category']."
				</div>
				<div class='fz10 badge badge-pill  col-1 col-md-1 '>
				".$row_top['views']."
				</div>
				<div class='fz10 col-3 col-md-3 '>
$time_top <br/> $date_top
				</div>
				<div class='fz10 col '>
 ".$row_top['source']."
				</div>
		</div>
	</div>";
}
$result_top->free();
} 
    else
{ 
	echo "<div class='col-lg-5 mx-auto'><em>здесь нет того, что вы ищите</em></div>";
}
}
	echo"</div>";
	
	
	echo"<div class='col-lg-6 mx-auto mb-5 shadow p-3 bg-dark text-light  rounded ' >ПОСЛЕДНИЕ НОВОСТИ<HR>";  
if($result = $db->query($sql)) 
{
    if($result->num_rows > 0) 
    {
		while($row = $result->fetch_array())
{
	
$datetime =$row['datetime'];
$date= strftime(' %d %b', strtotime($datetime));
$time=$row['time'];
$time= date(' H:i', strtotime($time));
echo "
	<div class='col-md-12 col-12 mx-auto mb-3 shadow p-1 bg-light text-dark  rounded'>
<a class= 'h5 text-dark stretched-link' href=\"../assets/linkcounter.php?id={$row['news_id']}\" target=\"_blank\">{$row['zag']}</a>
		<div class='row p-1  align-items-end'>
				<div class='fz10 col-4 col-sm-4 '>
{$row['category']} 
				</div>
				<div class='fz10 badge badge-pill  col-1 col-md-1'>
					{$row['views']} 
				</div>
				<div class='fz10 col-3 col-md-3 '>
$time <br/> $date	  
				</div>
				<div class='col fz10'>
				 " . $row['source'] . "
				</div>
		</div>
	</div>
";
}
$result->free();
} 
    else
{ 
	echo "<div class='col-lg-6 mx-auto'><em>здесь нет того, что вы ищите</em></div>";
}
}
echo "</div>";



echo"<div class='col-lg-2 mx-auto  shadow p-3 bg-dark text-white rounded'>ОБСУЖДАЕМЫЕ КАТЕГОРИИ<HR>";
if($result_cat = $db->query($sql_cat)) 
{
    if($result_cat->num_rows >= 0) 
    {
while($row_cat = $result_cat->fetch_array())
{
	echo"
	<div class='col-md-12 col-12 mx-auto mb-1 shadow p-1 bg-light  rounded'>
	<a class= 'text-dark stretched-link' href=\"../assets/news.php?cat_id={$row_cat['category_id']}\" target=\"_blank\">{$row_cat['category']}</a>
	</div>
	";
}
$result_cat->free();
	}
}
echo"</div>";



echo"</div></div>";


///////

<nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
<a class="navbar-brand" href="../">NewsAgent</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php?cat">Лента новостей <span class="sr-only">(current)</span></a>
      </li>
    
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Категории</a>
        <div class="dropdown-menu" aria-labelledby="dropdown03">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="../assets/feed.php">Ваши подписки</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="../index.php?logout">выйти</a>
    </li>

    ';
    if ((!empty($_SESSION['status']))&&($_SESSION['status'] == 1))
      {
   echo'
   <li class="nav-item">
   <a class="nav-link" href="../assets/adminka.php">admin</a>
 </li>';
     }
     echo'
  </ul>
  <form class="form-inline my-2 my-md-0" method="get" action="../assets/search.php">
  <input class="form-control" type="text" name="search" placeholder="Поиск...">
  </form>
</div>
</nav>';  














<?php include "header.php";include "menu.php";?>
<div class="statistika">
<ul>
<li>БАСКЕТБОЛ</li>
<li>ФУТБОЛ</li>
<li>ХОККЕЙ</li>
<li>MMA</li>
<li>БОКС</li>
<li>ФОРМУЛА-1</li></ul>
<?php
mysql_query('SET NAMES utf8');

$sql = "SELECT `id_sport`, COUNT(1) AS `count` FROM `novost`  GROUP BY `id_sport`"; 

$res = mysql_query($sql);
 
while($row = mysql_fetch_assoc($res))
{
    echo '<div class="nstatey">','---- ', $row['count'],' СТАТЬИ</div> </br>';
    
}
$graf_b= mysql_query("SELECT `id_sport`, COUNT(1) AS `count` FROM `novost` where  id_sport=1"); 
$graf_b = mysql_fetch_assoc($graf_b);

$graf_f = mysql_query("SELECT `id_sport`,COUNT(1) AS `count` FROM `novost` where id_sport=2");
$graf_f = mysql_fetch_assoc($graf_f);

$graf_h= mysql_query("SELECT `id_sport`, COUNT(1) AS `count` FROM `novost` where  id_sport=3"); 
$graf_h = mysql_fetch_assoc($graf_h);

$graf_mma = mysql_query("SELECT `id_sport`,COUNT(1) AS `count` FROM `novost` where id_sport=4");
$graf_mma = mysql_fetch_assoc($graf_mma);

$graf_box= mysql_query("SELECT `id_sport`, COUNT(1) AS `count` FROM `novost` where  id_sport=5"); 
$graf_box = mysql_fetch_assoc($graf_box);

$graf_for = mysql_query("SELECT `id_sport`,COUNT(1) AS `count` FROM `novost` where id_sport=6");
$graf_for = mysql_fetch_assoc($graf_for);       ?>
</div>
<div id="graf"></div>

<script  type="text/javascript">

var graf_b = '<?php echo $graf_b['count'];?>';
var graf_f = '<?php echo $graf_f['count'];?>';
var graf_h = '<?php echo $graf_h['count'];?>';
var graf_mma = '<?php echo $graf_mma['count'];?>';
var graf_box = '<?php echo $graf_box['count'];?>';
var graf_for = '<?php echo $graf_for['count'];?>';


$(document).ready(function(){
 
    data1 = [[['Баскетбол', +graf_b],['Футбол', +graf_f], ['Хоккей', +graf_h],['MMA',+graf_mma],
    ['Бокс', +graf_box], ['Формула-1', +graf_for]]];
    toolTip1 = ['БАСКЕТБОЛ','ФУТБОЛ','ХОККЕЙ','MMA','БОКС','ФОРМУЛА-1'];
 
    var plot1 = jQuery.jqplot('graf', 
        data1,
        {
            title: 'Статьи', 
            seriesDefaults: {
                shadow: false, 
                renderer: jQuery.jqplot.PieRenderer, 
                rendererOptions: { padding: 2, sliceMargin: 2, showDataLabels: true }            },
            legend: {
                show: true,
                location: 'e',
                renderer: $.jqplot.EnhancedPieLegendRenderer,
                rendererOptions: {
                    numberColumns: 1,
                    toolTips: toolTip1
                }
            },
        }
    );
});






</script>
<?php
include "footer.php"
?>









<!-- file admin_view_stat.php 22:10 31.03 -->
<?php   

$sql = ("SELECT source, SUM(views) AS views_sum FROM news GROUP BY source ORDER BY  SUM(views) DESC"); 
if($result = $db->query($sql)) 
{
    if($result->num_rows > 0) 
    {           
        echo'<div class="col-md-2"><hr/>';
while($row = $result->fetch_array())
{
    $source=$row['source'];
    $views_sum=$row['views_sum'];
echo "<a class='source_admin' href='#'>$source<span style='position:absolute;right:26px'>$views_sum</span></a>";
    

}   echo'</div>';
echo'</div>';       
    
} 
    else
{
        echo "<em>здесь нет того, что вы ищите</em>";
}
} 
else
{
    echo "ERROR: Could not able to execute $sql. " . $db->error;
}
$sql1 = ("SELECT cat, SUM(views) AS views_sum FROM news WHERE views>0 GROUP BY cat ORDER BY  SUM(views) DESC"); 
if($result1 = $db->query($sql1)) 
{
    if($result1->num_rows > 0) 
    {   
        
        
        echo'<div class="row"><div class="col-md-3"><hr/>';
while($row1 = $result1->fetch_array())
{
    $cat=$row1['cat'];
        $views_sum1=$row1['views_sum'];
echo "<a class='source_admin' href=\"#\">$cat<span style='position:absolute;right:46%;'>$views_sum1</span></a>";
    

}       echo'</div>';
echo'<div class="col-md-8"> GRAFIK';
//grafik
    
        
echo'</div></div></div>';   
        $result1->free();
} 
    else
{
        echo "<em>здесь нет того, что вы ищите</em>";
}
} 
else
{
    echo "ERROR: Could not able to execute $sql. " . $db->error;
}





/**/
<?php
require 'connection.php';
$link = mysqli_connect($host, $user, $password, $database)or die("Ошибка " . mysqli_error($link));
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
$sql_1=$link->query("SELECT news_url FROM news WHERE id_news='$id'"); 
$row_1 = mysqli_fetch_assoc($sql_1);
$url=$row_1['news_url'];
$sql=$link->query("SELECT * FROM url_ip WHERE url='$id' and ip='$ip'"); 
$row = mysqli_fetch_array($sql);
$ip_bd=$row['ip'];
 if ($ip != $ip_bd)
{
	$sql = $link->query("INSERT INTO url_ip (`id_url_ip`,`url`,`ip`)VALUES ('', '$id','$ip')"); 
	$sql = $link->query("INSERT INTO views (`id_views_item`,`news_id_news`)VALUES ('', '$id')"); 
	$sql=$link->query("UPDATE `views` SET views_count = views_count +1 WHERE news_id_news = '$id'");
}
mysqli_close($link);
header('Location:'.$url);
?>
// 
// 
// 15news
<!---->
<!---->
<?php
if ((!empty($_GET['id']))&&(!empty($_GET['time'])))
{
	$id=$_GET['id'];
	$sql=$db->query("SELECT source FROM news  WHERE news.date = '$date'  and news.id_news='$id'"); 
	$row_1 = $sql->fetch_assoc();
	$source=$row_1['source'];
	$source= "WHERE news.source='$source' and";  
	if ($_GET['time']==10)
	{
		$time='news.datetime  >= (now() - interval 10 minute) ORDER BY datetime DESC LIMIT 15 ';
	}
	elseif($_GET['time']==30)
	{
		$time='  news.datetime  >= (now() - interval 30 minute) ORDER BY datetime DESC LIMIT 20';
	}
	elseif($_GET['time']==60)
	{
		$time='  news.datetime  >= (now() - interval 60 minute) ORDER BY datetime DESC LIMIT 30 ';
	}

}
if ((empty ($_GET['id'])) &&(empty ($_GET['time'])))
{
	$date = date('Y-m-d');
	$source="WHERE news.date='$date' ";
	$time="ORDER BY datetime DESC LIMIT 20";
}
if ((!empty ($_GET['id'])) &&(empty ($_GET['time'])))
{
	$id=$_GET['id'];
	$sql=$db->query("SELECT source FROM news  WHERE news.date = '$date'  and news.id_news='$id'"); 
	$row_1 = $sql->fetch_assoc();
	$source=$row_1['source'];
	$source= "WHERE news.source='$source'"; 
	$time="ORDER BY datetime DESC LIMIT 20";
}
if ((empty($_GET['id']))&&(!empty($_GET['time'])))
{
	$source= "WHERE ";  
	if ($_GET['time']==10)
	{
		$time='news.datetime  >= (now() - interval 10 minute) ORDER BY datetime DESC LIMIT 15 ';
	}
	elseif($_GET['time']==30)
	{
		$time='  news.datetime  >= (now() - interval 30 minute) ORDER BY datetime DESC LIMIT 20';
	}
	elseif($_GET['time']==60)
	{
		$time='  news.datetime  >= (now() - interval 60 minute) ORDER BY datetime DESC LIMIT 30 ';
	}

}
if ((empty ($_GET['id'])) &&(empty ($_GET['time']))&&(!empty($_GET['cat'])))
{
	$id=$_GET['cat'];
	$sql=$db->query("SELECT cat FROM news  WHERE news.date = '$date'  and news.id_news='$id'"); 
	$row_1 = $sql->fetch_assoc();
	$cat=$row_1['cat'];
	$source= "WHERE news.cat='$cat'"; 
	$time="ORDER BY datetime DESC LIMIT 20";
}
$sql = ("SELECT * FROM news $source $time"); 
if($result = $db->query($sql)) 
{
    if($result->num_rows > 0) 
    {
		  echo"<div class='container mt-3'><div class='row'>
		  <div class='col-md-9'>
		  <table class='table table-hover'>";
            echo "<thead><tr>";
				echo "<th scope='col'>SRC</th>";
                echo "<th scope='col'>DATE</th>";
				echo "<th scope='col'>TIME</th>";
                echo "<th scope='col'>TITLE</th>";
                echo "<th scope='col'>CATEGORY</th>";
            echo "</tr></thead>";
		while($row = $result->fetch_array())
{
    echo "<tbody><tr>";
        echo "<td><a href='#'> " . $row['source'] . "</a></td>";
        echo "<td id='time'>" . $row['date'] . "</td>";
		echo "<td id='time'>" . $row['time'] . "</td>";
        echo "<td><a href=\"../assets/linkcounter.php?id={$row['id_news']}\" target=\"_blank\">{$row['zag']}</a></td>";
        echo "<td id='time'>" . $row['cat'] . "</td>";
    echo "</tr><tbody>";
}
        echo "</table></div>";
       $result->free();
} 
    else
{ echo "<div class='container mt-3'><div class='row'><div class='col-md-9'><table class='table table-hover'>";
        echo "<em>здесь нет того, что вы ищите</em>";
  echo "</table></div>";
}
} 
else
{
    echo "ERROR: Could not able to execute $sql. " . $db->error;
}
///**/?>
<div class="container ">
	
  <div class="row mt-5 mb-5  ">
    <div class="col-md-8 shadow p-3  bg-white rounded">
		<h6>
   <a href=\"../assets/linkcounter.php?id={$row['id_news']}\" target=\"_blank\">{$row['zag']}</a>
		</h6>
        <div class="row mt-2 mb-2">
			 <div class="col-4 col-sm-4">
          <a href='#'> " . $row['source'] . "</a>
        </div>
        <div class="col-4 col-sm-4">
            {$row['cat']}
        </div>
        <div class="col-4 col-sm-4">
         {$row['datetime']}
        </div>
      </div>
    </div>
  </div>


</div>



if (!empty ($_GET['id']))
{
	$id=$_GET['id'];
	$sql=$db->query("SELECT category FROM category  WHERE  category.category_id='$id'"); 
	$row_1 = $sql->fetch_assoc();
	$source=$row_1['category'];
}
elseif(empty($_GET['id']))
{
  $source='Теги';
}

echo
'<div class="container"><div class="row">
	<div class="col-lg-12 col  mx-auto ">
  <button class="btn btn-outline-secondary " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
  '.  $source  .'
  </button>
  

<div class="collapse" id="collapseExample">
  <div class="card card-body ">
  ';
$sql = ("SELECT category.category, time, category.category_id FROM category LEFT JOIN news ON category.category_id = news.category_id WHERE news.datetime  >= now() - interval 12 hour GROUP BY category.category  "); 

if($result = $db->query($sql)) 
{
       if($result->num_rows > 0) 
    {
		echo'<div class="ml-1">';
while($row = $result->fetch_array())
{
	
   
 
echo "

<a class='btn btn-outline-secondary btn-sm mr-1 mb-1 p-2' href=\"index.php?id=".$row['category_id']. ((!empty($_GET['time'])) ? '&time=' . $_GET['time'] : '') ."\">{$row['category']}</a>

";
}		echo'</div>';
	   $result->free();
} 
    else
{
        echo "<em>здесь нет того, что вы ищите</em>";
}
} 
else
{
    echo "ERROR: Could not able to execute $sql. " . $db->error;
}

echo"
</div>
</div></div></div></div>

";














{
	echo'<nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="../">NewsAgent</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample1" aria-controls="navbarsExample1" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarsExample1">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php?cat_id"><span class="sr-only">(current)</span>f</a>
        </li>
      
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Категории</a>
          <div class="dropdown-menu" aria-labelledby="dropdown1">';
          
            $sql_cat=("SELECT category.category_id,category.category FROM category,news	
            WHERE views>=1 and news.category_id = category.category_id GROUP BY category ORDER BY SUM(views) DESC LIMIT 12 ");//блок с категориями
                   
          
          
          if($result_cat = $db->query($sql_cat)) 
          {
              if($result_cat->num_rows >= 0) 
              {
          while($row_cat = $result_cat->fetch_array())
          {
            echo"
            <a class='dropdown-item' href='../index.php?cat&cat_id={$row_cat['category_id']}'>{$row_cat['category']}</a>
            ";
          }
          $result_cat->free();
            }
          }
                    
                     
                   
                      echo' </div>
                  </li>
               
               
              </ul>
              <ul class="navbar-nav justify-content-end">
          ';

          echo'</div>
        </li>
        
    </ul>

    <ul class="navbar-nav justify-content-end">
  
  
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Вход/Регистрация</a>
      <div class="dropdown-menu">
  <form class="px-4 py-3" action="../assets/authorization.php" method="post">
    <div class="form-group">
      <label for="exampleDropdownFormEmail1">Логин</label>
      <input   name="login" class="form-control" id="exampleDropdownFormEmail1" placeholder="Введите логин">
    </div>
    <div class="form-group">
      <label for="exampleDropdownFormPassword1">Пароль</label>
      <input type="password" name="password"  class="form-control" id="exampleDropdownFormPassword1" placeholder="Введите пароль">
    </div>
    
    <button type="submit"  class="btn btn-primary">Войти</button>
  </form>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="../assets/auth_page.php">Зарегистрироваться</a>
</div>
    </li>
    
</ul>

    
    <form class="form-inline my-2 my-md-0" method="get" action="../assets/search.php">
    <input class="form-control" type="text" name="search" placeholder="Поиск...">
    </form>
  </div>
  </nav>';  
}