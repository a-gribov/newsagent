<?php
$title='NewsAgent | Подписки';

$user_id=$_SESSION['user_id'];
$sql = ("SELECT feed_users.pars_item_id, pars_item.source, feed_users.read_notread, feed_users.id,feed_users.user_id FROM feed_users
 LEFT JOIN users ON feed_users.user_id =users.user_id
 LEFT JOIN pars_item ON feed_users.pars_item_id=pars_item.pars_item_id WHERE feed_users.user_id=$user_id and pars_item.allow_pars=1 
 ORDER BY  feed_users.pars_item_id DESC"); 
$result = $db->query($sql);
$row = $result->fetch_assoc();



$sql_count=$db->query("SELECT COUNT(*) pars_item_id FROM feed_users WHERE read_notread=1 and feed_users.user_id=$user_id ");
$sql_count = mysqli_fetch_array($sql_count)[0];

?>
<title><?=$title?></title>
<hr><hr>
<div class='text-center'>
<div class='text-center'>
Вы читаете: <?=$sql_count?> источника(ов)
</div>
<a class='btn btn-success btn-sm ml-4' href=index.php?feed&all_allow=<?=$row['user_id']?>>подписаться на всех</a>
<a class='btn btn-warning btn-sm' href=index.php?feed&all_disallow=<?=$row['user_id']?>>отписатсья от всех</a>
</div>
<div class='mt-5'></div>

<?php
if($result = $db->query($sql)) 
{
       if($result->num_rows > 0) 
    {

while($row = $result->fetch_array())
{
	
	
		if ($row['read_notread']==0)
		{
$a_cls_allow_dis="<a class='btn btn-success border-bottom border-dark  btn-sm' href=index.php?feed&allow={$row['id']}>подписка</a>";
$txt_wrnng='text-secondary';
		}
		else
		{
			
$a_cls_allow_dis="<a class='btn btn-warning border-bottom border-dark btn-sm' href=index.php?feed&disallow={$row['id']}>отписка &nbsp;</a>";
			$txt_wrnng='text-primary';
		}

	echo"
	<div class='container '>

  <div class='row col-lg-6 mx-auto mb-1 mt-1 border-top '>
    <div class='col-lg-4 col-6 mx-auto $txt_wrnng'>
	  <span class='text-dark'> {$row['pars_item_id']}</span>
			{$row['source']}
    </div>
    <div class='col-lg-1 col-1'>
	
   </div>
<div class='col-lg-4 col-4'>";
        echo $a_cls_allow_dis;
echo"</div>
	
  </div>
</div>

";

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



$meta='<meta http-equiv="refresh" content="0; url=../index.php?feed">';
if (!empty($_GET['allow']))
{
	$id=$_GET['allow'];
	$sql=$db->query("UPDATE feed_users SET read_notread=1 WHERE id='$id'"); 
	 echo $meta;

}
if (!empty($_GET['disallow']))
{
	$id=$_GET['disallow'];
	$sql=$db->query("UPDATE feed_users SET read_notread=0 WHERE id='$id'"); 
	
 echo $meta;
	}


	if (!empty($_GET['all_disallow']))
{
	$id=$_GET['all_disallow'];
	$sql=$db->query("UPDATE feed_users SET read_notread=0 WHERE user_id='$id'"); 
	
 echo $meta;
	}

	if (!empty($_GET['all_allow']))
	{
		$id=$_GET['all_allow'];
		$sql=$db->query("UPDATE feed_users SET read_notread=1 WHERE user_id='$id'"); 
		
	 echo $meta;
		}

?>