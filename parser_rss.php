<?php
error_reporting(E_ALL);
set_time_limit(600);
require 'assets/connection.php';
$sql_sel_pars_item = ("SELECT * FROM pars_item WHERE allow_pars=1"); 
if($result = $db->query($sql_sel_pars_item)) {
while (($row_sspi = $result->fetch_assoc()) != false) {
	$source=$row_sspi['pars_item_id'];
	$url=$row_sspi['url'];
		parser_rss($url,$source);}}
$result->free();
function parser_rss($url,$source){	
require_once 'phpQuery/phpQuery.php';
require 'assets/connection.php';
$file = file_get_contents($url);
$doc = phpQuery::newDocument($file);
    foreach($doc->find('item') as $article){
		$article = pq($article);
		$cat=trim($article->find('category')->text());
		$cat=mb_convert_case($cat, MB_CASE_TITLE, "UTF-8");
		$news_url =$article->find('link:eq(0)')->text();
		$zag = trim($article->find('title')->text());
		$datetime= $article->find('pubDate')->text();
		$datetime = date('Y-m-d G:i:s',strtotime($datetime));
		$time=date('G:i:s',strtotime($datetime));
		$date=date('Y-m-d',strtotime($datetime));
		if (empty($cat))		{
			$cat='В мире';		}
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
//update if exist, insert if not
$sql=$db->query("SELECT 1 zag FROM news WHERE zag='$zag'"); 
if (!$sql || $sql->num_rows == 0) {
$sql = $db->query("INSERT INTO news (`news_id`,`pars_item_id`,`news_url`,`category_id`, `zag`,`datetime`,`time`, `date`) 
VALUES ('', '$source','$news_url','$cat', '$zag', '$datetime', '$time','$date')");}
else{
$sql=$db->query("UPDATE news SET datetime= '$datetime', date='$date', time='$time' where zag ='$zag'	");	}}
phpQuery::unloadDocuments();}$db->close();