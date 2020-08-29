<?php session_start();

$host = 'localhost';
$database = 'pars';
$user = 'root';
$password = 'root';
$db = new mysqli($host, $user, $password, $database)or die("Ошибка " . mysqli_error($db));
$db->set_charset('utf8');

setlocale(LC_ALL, 'ru_RU.UTF-8');



if(isset($_GET['admin'])){

//admin_add_source  запретить\разрешить\удалить источники
if ($_GET['admin']=='source')
{
$meta='<meta http-equiv="refresh" content="0; url=index.php?admin=source">';

//admin_add_source  добавить источники
if((!empty($_POST['inputSource'])) && !empty($_POST['inputUrl']))
{
	$source = $_POST['inputSource'];
	$url = $_POST['inputUrl'];

	$sql=$db->query("SELECT 1 source FROM pars_item WHERE source='$source'"); 
	if (!$sql || $sql->num_rows == 0) 
{
	
		$sql = $db->query("INSERT INTO pars_item (`pars_item_id`,`source`,`url`,`allow_pars`) 
	VALUES ('', '$source','$url','0')");
	echo $meta;
}
else
{
	// echo '<meta http-equiv="refresh" content="0; url=/../index.php?admin=source">';
}
}


if (!empty($_GET['allow']))
{
	$id=$_GET['allow'];
	$sql=$db->query("UPDATE pars_item SET allow_pars=1 WHERE pars_item_id='$id'"); 
    echo $meta;	
}
if (!empty($_GET['disallow']))
{
	$id=$_GET['disallow'];
	$sql=$db->query("UPDATE pars_item SET allow_pars=0 WHERE pars_item_id='$id'"); 
	
    echo $meta;	
	
	
}
// if (!empty($_GET['delete']))
// {
// 	$id=$_GET['delete'];
// 	$sql=$db->query("DELETE FROM pars_item WHERE pars_item_id='$id'"); 
	
//  echo $meta;	
// }
}


//admin_news  удалить новость

if ($_GET['admin']=='news')
{
    $meta='<meta http-equiv="refresh" content="0; url=index.php?admin=news">';

    
    if (!empty($_GET['delete']))
    {
        $id=$_GET['delete'];
        $sql=$db->query("DELETE FROM news WHERE news_id='$id'"); 
        
     echo $meta;	
    }

}
}





//cat.php
if (isset($_GET['cat_id']))
{
    $title='NewsAgent | Лента новостей';
setlocale(LC_ALL, 'ru_RU.UTF-8');
//пагинация



if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}

$no_of_records_per_page = 15;
$offset = ($pageno-1) * $no_of_records_per_page;

if (isset ($_SESSION['user_id']))			
{
	
	if(!empty($_GET['cat_id']))
{
	$categ_id=$_GET['cat_id'];
	$total_pages_sql = "SELECT COUNT(*) FROM news,feed_users,pars_item
 WHERE pars_item.pars_item_id=news.pars_item_id 
 and feed_users.pars_item_id=news.pars_item_id and feed_users.user_id='{$_SESSION['user_id']}' 
 and feed_users.read_notread=1 and news.category_id='$categ_id' ";
}
else 
{
	$total_pages_sql = "SELECT COUNT(*) FROM news,feed_users,pars_item
 WHERE pars_item.pars_item_id=news.pars_item_id 
 and feed_users.pars_item_id=news.pars_item_id and feed_users.user_id='{$_SESSION['user_id']}' 
 and feed_users.read_notread=1";
}

}
else
{		
		if(!empty($_GET['cat_id']))
	{
		$categ_id=$_GET['cat_id'];
		$total_pages_sql = "SELECT COUNT(*) FROM news WHERE news.category_id='$categ_id' ";	
	}
	else 
	{
		$total_pages_sql = "SELECT COUNT(*) FROM news";	
	}

	
}

$result_pages = $db->query($total_pages_sql);
$total_rows = mysqli_fetch_array($result_pages)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);




if (isset ($_SESSION['user_id']))			
{
	$feed_users=",feed_users.read_notread";
	$lft_jn_prs_itm="LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id";
	$left_join_where_feed="LEFT JOIN feed_users ON feed_users.pars_item_id=news.pars_item_id WHERE feed_users.user_id='{$_SESSION['user_id']}' and feed_users.read_notread=1";

	if ((isset ($_GET['cat_id']))&&(!empty($_GET['cat_id'])))
	{
		$cat_id=$_GET['cat_id'];
		$sql=("SELECT news.news_id, news.datetime, news.time, news.zag, category.category,news.views,pars_item.source $feed_users FROM news 
		$lft_jn_prs_itm
		LEFT JOIN category ON category.category_id=news.category_id 
		$left_join_where_feed 
		and  news.category_id = $cat_id	and category.category_id=$cat_id 
		ORDER BY news.datetime DESC LIMIT $offset, $no_of_records_per_page ");//блок с последними новостями
			$result = $db->query($sql);
			$row = $result->fetch_array();
			$cat=$row['category'];
	}
	else
	{
		$cat_id='';
		$sql=("SELECT news.news_id, news.datetime, news.time, news.zag, category.category,news.views,pars_item.source $feed_users FROM news 
		$lft_jn_prs_itm
		LEFT JOIN category ON category.category_id=news.category_id 
		$left_join_where_feed 
		ORDER BY news.datetime DESC LIMIT $offset, $no_of_records_per_page ");//блок с последними новостями
			$cat='ЛЕНТА НОВОСТЕЙ';
	}
	$sql_cat=("SELECT category.category_id,category.category $feed_users FROM category,news	$lft_jn_prs_itm $left_join_where_feed
	and views>=1 and news.category_id = category.category_id GROUP BY category ORDER BY SUM(views) DESC LIMIT 12 ");//блок с категориями
	$and=' and ';
}
else 
{	
	$feed_users='';
	$lft_jn_prs_itm=''	;
	$left_join_where_feed='';
	if ((isset ($_GET['cat_id']))&&(!empty($_GET['cat_id'])))
	{
		$cat_id=$_GET['cat_id'];
		$sql=("SELECT news.news_id, news.datetime, news.time, news.zag, category.category,news.views,pars_item.source  FROM news 
		LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
		LEFT JOIN category ON category.category_id=news.category_id 
		WHERE  news.category_id = $cat_id	and category.category_id=$cat_id 
		ORDER BY news.datetime DESC LIMIT $offset, $no_of_records_per_page ");//блок с последними новостями
		$result = $db->query($sql);
		$row = $result->fetch_array();
		$cat=$row['category'];
	}
	else
	{
		$cat_id='';
		$sql = ("SELECT news.news_id, news.datetime,news.time,news.zag,category.category,news.views,pars_item.source  FROM news 
	LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
	LEFT JOIN category ON category.category_id=news.category_id
	 ORDER BY news.datetime DESC LIMIT $offset, $no_of_records_per_page ");//блок с последними новостям
	 
	 $cat='ЛЕНТА НОВОСТЕЙ';
	}



	$sql_cat=("SELECT category.category_id,category.category FROM category,news	
	WHERE views>=1 and news.category_id = category.category_id GROUP BY category 
	ORDER BY SUM(views) DESC LIMIT 12 ");//блок с категориями
	$and=' WHERE ';
}

$result = $db->query($sql);
$row = $result->fetch_array();


$sql_top=("SELECT news.news_id, news.datetime, news.time, news.zag, category.category,news.views,pars_item.source $feed_users FROM news 
LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
LEFT JOIN category ON category.category_id=news.category_id 
$left_join_where_feed ORDER BY views DESC LIMIT 5 ");//блок с топ новостями


$top_line_latest_news="
<div class='container-fluid mt-2 p-3'>
<div class='row mt-3 align-items-start'>

<div class='col-lg-8 col-md-5 mx-auto shadow  p-3 bg-dark text-light  rounded text-center' >
<div class='mb-2'>$cat</div>";

}









else
{
    
if (isset ($_SESSION['user_id']))			
{
	$feed_users=",feed_users.read_notread";
	$lft_jn_prs_itm="LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id";
	$left_join_where_feed="LEFT JOIN feed_users ON feed_users.pars_item_id=news.pars_item_id WHERE feed_users.user_id='{$_SESSION['user_id']}' and feed_users.read_notread=1";
	$sql_cat=("SELECT category.category_id,category.category 
	$feed_users FROM category,news	$lft_jn_prs_itm $left_join_where_feed
  and views>=1 and news.category_id = category.category_id
	 GROUP BY category ORDER BY SUM(views) DESC LIMIT 14 ");//блок с категориями
}
else 
{	
	$feed_users='';
	$lft_jn_prs_itm='';
	$left_join_where_feed='';
	$sql_cat=("SELECT category.category_id,category.category
	 FROM category,news	
  WHERE views>=1 and news.category_id = category.category_id 
	GROUP BY category ORDER BY SUM(views) DESC LIMIT 12 ");//блок с категориями
}

$sql_top=("SELECT news.news_id, news.datetime, news.time, news.zag, category.category,news.views,pars_item.source $feed_users FROM news 
LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
LEFT JOIN category ON category.category_id=news.category_id 
$left_join_where_feed ORDER BY views DESC LIMIT 5 ");//блок с топ новостями

$sql = ("SELECT news.news_id, news.datetime,news.time,news.zag,category.category,news.views,pars_item.source $feed_users FROM news 
	LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
	LEFT JOIN category ON category.category_id=news.category_id
     $left_join_where_feed ORDER BY news.datetime DESC LIMIT 14 ");//блок с последними новостями
     

$top_line_latest_news="<div class='container-fluid mt-2 p-3'>
<div class='row mt-3 align-items-start'>

<div class='col-lg-8 col-md-12 mx-auto shadow  p-3 bg-dark text-light rounded text-center' >
<!-- 
<a class='btn btn-outline-light  ' href='index.php?cat_id'> Открыть ленту</a><HR> -->
<div class='mb-2'>ПОСЛЕДНИЕ</div>";
}


