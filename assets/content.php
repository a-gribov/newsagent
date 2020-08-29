<?php
echo $top_line_latest_news;
if($result = $db->query($sql))	{
	    if($result->num_rows > 0)	{
		while($row = $result->fetch_array())	{
$cat=$row['category'];
$datetime =$row['datetime'];
$date= strftime('%d/%m', strtotime($datetime));
$time=$row['time'];
$time= date(' H:i', strtotime($time));
echo"<div class='col-lg-12 col-md-12 col-12 mx-auto mb-3 shadow p-1 bg-light text-dark   text-left  rounded'>
<a class= ' h5 text-dark stretched-link' href=\"../assets/linkcounter.php?id={$row['news_id']}\" target=\"_blank\">
	<span class='p-1  rounded bg-secondary text-light '>$time</span> {$row['zag']}</a>
		<div class=' border-top border- row p-1 mx-auto align-items-end'>
		<div class='fz10 col-2 col-md-1	'>$date</div>		
		<div class='fz10 col-md-5 col-5 '>{$row['category']}</div>
				<div class='fz10 col-2 col-md-1	'>{$row['views']}</div>
				<div class='fz10  col-2 col-md-2 '>{$row['source']}</div>
		</div>
	</div>";
}
} 
    else{ 
	echo "<div class='col-lg-6 mx-auto'><em>здесь нет того, что вы ищите</em></div>";
				}
}
if (isset($_GET['cat_id']))  {
	?>
<nav>
  <ul class="pagination justify-content-center ">
  <li class='<?php if($pageno <= 1){ echo 'page-item disabled'; } ?>'>
	<a class="page-link " href="<?php echo	'?'.((!empty($_GET['cat_id']))?'cat_id=' . $_GET['cat_id'] : 'cat_id')	.'&pageno=1' ?>">
	Первая</a>
    </li>
    <li class='<?php if($pageno <= 1){ echo 'page-item disabled'; } ?>'>
    <a class='page-link' href='<?php if($pageno <= 1){ echo '#'; } else  { echo '?'. ((!empty($_GET['cat_id']))?'cat_id=' . $_GET['cat_id'] : 'cat_id')  .'&pageno='.($pageno - 1); } ?>'>
		«Назад</a>
    </li>
	<li class="page-item <?php if($pageno >= 1){ echo 'active'; } ?>" aria-current="page">
      <a class="page-link " >
	  <?php  echo $pageno; ?></a>
    </li>
 <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"	aria-current="page">
      <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo '?'. ((!empty($_GET['cat_id']))?'cat_id=' . $_GET['cat_id'] : 'cat_id')  .'&pageno='.($pageno + 1); } ?>">
	  <?php  echo 'Далее»';  ?></a>
    </li>
<li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; }?>">
      <a class="page-link " href="<?php echo	'?'.((!empty($_GET['cat_id']))?'cat_id=' . $_GET['cat_id'] : 'cat_id')	.'&pageno='.$total_pages; ?>">
        Последняя
      </a>
    </li>
  </ul>
</nav>
<?php
}
echo "</div>
<div class='col-lg-3 col-12 mx-auto shadow p-3 bg-dark text-light rounded text-center'><div class='mb-2'>ПОПУЛЯРНОЕ</div>";

if($result_top = $db->query($sql_top))	{
    if($result_top->num_rows > 0)	{
		while($row_top = $result_top->fetch_array())	{
$datetime_top =$row_top['datetime'];
$date_top= strftime('%d/%m', strtotime($datetime_top));
$time_top=$row_top['time'];
$time_top= date(' H:i', strtotime($time_top));
	echo"
	<div class='col-lg-12 col-md-12 col-12 mx-auto mb-3 shadow p-1 bg-light text-dark   text-left  rounded'>
<a class='h5 text-dark stretched-link' href=\"../assets/linkcounter.php?id={$row_top['news_id']}\" target=\"_blank\">
	<span class='p-1  rounded bg-secondary text-light '>{$row_top['views']}</span> {$row_top['zag']}</a>
		<div class=' border-top  row p-1 mx-auto align-items-end'>
		<div class='fz10 col-2 col-md-2	'>$date</div>		
		<div class='fz10  col '>{$row_top['category']}</div>
		<div class='fz10  col '>{$row_top['source']}</div>
		</div>
	</div>";
}
$result_top->free();
} 
    else{ 
	echo "<div class='col-lg-5 mx-auto'><em>здесь нет того, что вы ищите</em></div>";
				}
}
echo"<div class='col-lg-12 col-md-5 col-sm-5 mx-auto p-1 text-white rounded text-center'>ОБСУЖДАЕМЫЕ КАТЕГОРИИ	";
if($result_cat = $db->query($sql_cat))	{
    if($result_cat->num_rows >= 0)	{
while($row_cat = $result_cat->fetch_array())	{
	echo"<div class='col-md-5 col-lg-12 mx-auto mb-1 shadow p-1 bg-light text-left rounded'>
	<a class= 'text-dark stretched-link ' href=\"../index.php?cat_id={$row_cat['category_id']}\" >{$row_cat['category']}</a>
	</div>";
}
$result_cat->free();
}
}
echo"</div></div></div></div>";