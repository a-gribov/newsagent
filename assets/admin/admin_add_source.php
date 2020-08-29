<?php
$title='NewsAgent | Источники';
$sql = ("SELECT * FROM pars_item ORDER BY pars_item_id DESC"); 
?>
<title><?=$title?></title>
 <hr>  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
<form action="/index.php?admin=source" method="POST">
  <div class="form-group row mt-5">
    <label for="inputSource" class="col-sm-2 col-form-label">Название источника</label>
    <div class="col-sm-4">
      <input required name="inputSource" type="text" class="form-control" id="inputSource" placeholder="Название источника">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputUrl" class="col-sm-2 col-form-label">URL</label>
    <div class="col-sm-9">
      <input required name="inputUrl" type="text" class="form-control" id="inputUrl" placeholder="URL">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
  </div>
</form>
<hr>
<?php

$sql = ("SELECT * FROM pars_item ORDER BY allow_pars, pars_item_id DESC"); 
if($result = $db->query($sql)) 
{
       if($result->num_rows > 0) 
    {

while($row = $result->fetch_array())
{
	
	
		if ($row['allow_pars']==0)
		{
$a_cls_allow_dis="<a class='btn btn-warning btn-sm mt-1' href=index.php?admin=source&allow={$row['pars_item_id']}>запрещено</a>";
$txt_wrnng='text-secondary';
		}
		else
		{
			
$a_cls_allow_dis="<a class='btn btn-success btn-sm mt-1' href=index.php?admin=source&disallow={$row['pars_item_id']}>разрешено&nbsp;</a>";
			$txt_wrnng='text-primary';
		}

?>

	<div class='container'>

  <div class='border-left  border-top  row mb-2' id="<?=$row['pars_item_id']?>">
    <div class='col-lg-2 col-md-2 col-5 <?=$txt_wrnng?>'>
   <span class='text-dark'> <?=$row['pars_item_id']?></span>
	<?=$row['source']?>
    </div>
    
<div class='col-lg-2  col-7 text-right mb-2' >
        <?=$a_cls_allow_dis?>
</div>
<!-- 
	<div class='col-lg-1  col text-right mt-1 mb-3'>
		<div class='dropdown dropright ' >
     <a class='btn btn-danger btn-sm  dropdown-toggle' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    удалить
  </a>
	  
	  <div class='dropdown-menu dropright ' aria-labelledby='dropdownMenuLink'>
   
    <a class='btn-sm dropdown-item ' href=index.php?admin=source&delete=<?=$row['pars_item_id']?>>подтвердить</a>
  </div>
	  
	  </div>
    </div> -->

  </div>
</div>

<?php

}		
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
?>