<?php
if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}

$no_of_records_per_page = 15;
$offset = ($pageno-1) * $no_of_records_per_page;


$total_pages_sql = "SELECT COUNT(*) FROM news";
$result_pages = $db->query($total_pages_sql);
$total_rows = mysqli_fetch_array($result_pages)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql = ("SELECT news.news_id, news.datetime,news.time,news.zag,category.category,news.views,pars_item.source  FROM news 
LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id
LEFT JOIN category ON category.category_id=news.category_id
 ORDER BY news.datetime DESC LIMIT $offset, $no_of_records_per_page ");//блок с последними новостям

    ?>
    
     <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 mx-auto shadow  bg-secondary   rounded text-center">





     <?php
if($result = $db->query($sql)) 
{
	
    if($result->num_rows > 0) 
    {
		while($row = $result->fetch_array())
{


	$cat=$row['category'];
	
$datetime =$row['datetime'];
$date= strftime('%d/%m', strtotime($datetime));
$time=$row['time'];
$time= date(' H:i', strtotime($time));

echo "
  <div class='col-lg-12 col-md-12 col-12 mx-auto mb-2 shadow p-1 bg-light  text-left  rounded'>
  <div class='row'>
<div class='col-lg-9   col-12'>
<a class= ' h6 ' href=\"../assets/linkcounter.php?id={$row['news_id']}\" target=\"_blank\">
  <span class='p-1  rounded bg-secondary text-light '>$time</span> {$row['zag']}</a>
  </div>

  <div class='col-lg-1 col-6'></div>
  <div class='col-lg-2 col-6  text-right'>
  
  <div class='dropdown dropright ' >
     <a class='btn btn-danger text-light btn-sm  dropdown-toggle' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    удалить
  </a>
	  
	  <div class='dropdown-menu dropright ' aria-labelledby='dropdownMenuLink'>
   
    <a class='btn-sm dropdown-item ' href=index.php?admin=news&delete={$row['news_id']}>подтвердить</a>
  </div>
	  
	  </div>
  
  </div>

  </div>


		<div class=' border-top row p-1 mx-auto align-items-end'>
		<div class='fz10 col-2 col-md-1	'>$date</div>		
		<div class='fz10 col-md-5 col-5 '>{$row['category']}</div>
				
				<div class='fz10 col-2 col-md-1	'>{$row['views']}</div>
				<div class='fz10  col-2 col-md-2 '>{$row['source']}</div>
    </div>
  
	</div>
";
}

} 
    else
{ 
	echo "<div class='col-lg-6 mx-auto'><em>здесь нет того, что вы ищите</em></div>";
}
}


if ($result->num_rows >14)  {
	// $result->free();
	?>


<nav>
  <ul class="pagination justify-content-center ">
  <li class='<?php if($pageno <= 1){ echo 'page-item disabled'; } ?>'>
	<a class='page-link' href='?admin=news&pageno=1'>Первая</a>
    </li>
    <li class='<?php if($pageno <= 1){ echo 'page-item disabled'; } ?>'>
    <a class='page-link' href='<?php if($pageno <= 1){ echo '#'; } else { echo '?admin=news&pageno='.($pageno - 1); } ?>'>«Назад</a>
    </li>

    <!-- <li class="page-item <?php if($pageno <= 1){ echo 'active'; } ?>" aria-current="page">
      <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo '?admin=news&pageno='.($pageno - 1); } ?>">
	  <?php if($pageno <= 1){ echo '1'; } else { echo $pageno - 1; } ?></a>
    </li> -->

	<li class="page-item <?php if($pageno >= 1){ echo 'active'; } ?>" aria-current="page">
      <a class="page-link " >
	  <?php  echo $pageno; ?></a>
    </li>

    <!-- <li class="page-item '<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" aria-current="page">
      <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo '?admin=news&pageno='.($pageno + 1); } ?>">
	  <?php  echo $pageno + 1;  ?></a>
    </li> -->

    <li class="page-item '<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" aria-current="page">
      <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo '?admin=news&pageno='.($pageno + 1); } ?>">
	  <?php  echo 'Далее»';  ?></a>
    </li>

    <li class="page-item <?php if($pageno >= $total_pages){ echo '#'; } else { echo '?admin=news&pageno='.($pageno + 1); } ?>">
      <a class="page-link " href="?admin=news&pageno=<?php echo $total_pages; ?>">
        Последняя
      </a>
    </li>
  </ul>
</nav>
<?php
}