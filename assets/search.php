<?php
if(isset($_GET['search']))
{
$title='NewsAgent | Поиск';
echo'<title>'.$title.'</title><br>';
$search=(isset($_GET['search'])) ? $_GET['search'] : null;
$search =mysqli_escape_string ($db,trim($search));
if(empty($search)){
	echo"<div class='container-fluid p-3'>
  <div class='row align-items-start'>
  
  <div class='col-lg-10 col-md-5 mx-auto shadow mb-5 p-3 bg-dark text-light  rounded text-center' >Пустой запрос";
}
else if (iconv_strlen($search,'utf-8')< 2){
	echo"<div class='container-fluid p-3'>
  <div class='row align-items-start'>
  
  <div class='col-lg-10 col-md-5 mx-auto shadow mb-5 p-3 bg-dark text-light  rounded text-center' >Короткий запрос";
}
else{
  if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 15;
$offset = ($pageno-1) * $no_of_records_per_page;
$total_pages_sql = "SELECT COUNT(*) FROM news";	

if(isset($_SESSION['user_id']))
{
  $total_pages_sql = "SELECT COUNT(*) FROM news,feed_users,pars_item
 WHERE pars_item.pars_item_id=news.pars_item_id 
 and feed_users.pars_item_id=news.pars_item_id and feed_users.user_id='{$_SESSION['user_id']}' 
 and feed_users.read_notread=1 and news.zag LIKE '%$search%' ORDER BY news.datetime";
}
else
{
  $total_pages_sql = "SELECT COUNT(*) FROM news,pars_item
  WHERE pars_item.pars_item_id=news.pars_item_id  and news.zag LIKE '%$search%' ORDER BY news.datetime";
}

$result_pages = $db->query($total_pages_sql);
$total_rows = mysqli_fetch_array($result_pages)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);




    
if(isset($_SESSION['user_id']))
{
  $sql = "SELECT * FROM news,feed_users,pars_item,category
 WHERE pars_item.pars_item_id=news.pars_item_id 
 and feed_users.pars_item_id=news.pars_item_id 
 and feed_users.user_id='{$_SESSION['user_id']}' 
 and feed_users.read_notread=1 
 and category.category_id=news.category_id 
 and news.zag LIKE '%$search%' ORDER BY news.datetime DESC LIMIT $offset, $no_of_records_per_page";
}
else
{
  $sql="SELECT *
  FROM news 
  LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
  LEFT JOIN category ON category.category_id=news.category_id WHERE news.zag LIKE '%$search%' ORDER BY news.datetime
   DESC LIMIT $offset, $no_of_records_per_page";
}

	$query = mysqli_query($db,$sql);
    if ($query->num_rows==0)

    {
        echo "<br><br><div class='ml-5'>по Вашему запросу: $search ничего не найдено</div>";
	}
    else
    {
      echo"<div class='container-fluid p-3'>
      <div class='row align-items-start'>
      
      <div class='col-lg-10 col-md-5 mx-auto shadow mb-5 p-3 bg-dark text-light  rounded text-center' >Результаты поиска по запросу: $search<hr/>";

        while ($row=mysqli_fetch_array ($query)) 
        {
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $datetime =$row['datetime'];
        $date= strftime(' %d %b', strtotime($datetime));
        $time=$row['time'];
        $time= date(' H:i', strtotime($time));
        echo "
        <div class='col-lg-12 col-md-12 col-12 mx-auto mb-3 shadow p-1 bg-light text-dark   text-left  rounded'>

        <a class= ' h5 text-dark stretched-link' href=\"../assets/linkcounter.php?id={$row['news_id']}\" target=\"_blank\">
            <span class='p-1  rounded bg-secondary text-light '>$time</span> {$row['zag']}</a>
                <div class=' border-top border- row p-1 mx-auto align-items-end'>
                <div class='fz10 col-2 col-md-1	'>$date</div>		
                <div class='fz10 col-md-5 col-5 '>{$row['category']}</div>
                        
                        <div class='fz10 col-2 col-md-1	'>{$row['views']}</div>
                        <div class='fz10  col-2 col-md-2 '>{$row['source']}</div>
                </div>
            </div>
        ";
		}
    }


    if (isset($_GET['search']))  {

?>
<nav>
  <ul class="pagination justify-content-center ">
  <li class='<?php if($pageno <= 1){ echo 'page-item disabled'; } ?>'>
	<a class="page-link " href="<?php echo	'?'.((!empty($_GET['search']))?'search=' . $_GET['search'] : 'search')	.'&pageno=1' ?>">
	Первая</a>
    </li>
    <li class='<?php if($pageno <= 1){ echo 'page-item disabled'; } ?>'>
    <a class='page-link' href='<?php if($pageno <= 1){ echo '#'; } else  { echo '?'. ((!empty($_GET['search']))?'search=' . $_GET['search'] : 'search')  .'&pageno='.($pageno - 1); } ?>'>
		«Назад</a>
    </li>
<li class="page-item <?php if($pageno >= 1){ echo 'active'; } ?>" aria-current="page">
      <a class="page-link " >
	  <?php  echo $pageno; ?></a>
    </li>
    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"	aria-current="page">
      <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo '?'. ((!empty($_GET['search']))?'search=' . $_GET['search'] : 'search')  .'&pageno='.($pageno + 1); } ?>">
	  <?php  echo 'Далее»';  ?></a>
    </li>

    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; }?>">
      <a class="page-link " href="<?php echo	'?'.((!empty($_GET['search']))?'search=' . $_GET['search'] : 'search')	.'&pageno='.$total_pages; ?>">
        Последняя
      </a>
    </li>
  </ul>
</nav>
    <?php
    }
    $query->free();
echo'</div></div>';
}
}