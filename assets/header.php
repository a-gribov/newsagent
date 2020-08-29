
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/style.css">
 <link rel="stylesheet" href="../styles/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 
  <link rel="stylesheet" type="text/css" href="../JavaScript/jqplot/jquery.jqplot.css" />
  
<?php
$title='NewsAgent | Ваши новости';
echo"
<nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
<a class='navbar-brand' href='../'>NewsAgent</a>
  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarsExample03' aria-controls='navbarsExample03' aria-expanded='false' aria-label='Toggle navigation'>
    <span class='navbar-toggler-icon'></span>
  </button>
  <div class='collapse navbar-collapse' id='navbarsExample03'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item active'>
        <a class='nav-link' href='index.php?cat_id'><span class='sr-only'>(current)</span>Лента новостей</a>
      </li>
      <li class='nav-item active'>
      <a class='nav-link' href='index.php?about'><span class='sr-only'>(current)</span>О Нас</a>
    </li>
    
      <li class='nav-item active dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='dropdown03' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Категории</a>
        <div class='dropdown-menu' aria-labelledby='dropdown03'>";

if (!empty($_SESSION['login']))
  { 
      $sql_cat=("SELECT category.category_id,category.category ,feed_users.read_notread FROM category,news	
      LEFT JOIN  pars_item ON pars_item.pars_item_id=news.pars_item_id 
      LEFT JOIN feed_users ON feed_users.pars_item_id=news.pars_item_id WHERE feed_users.user_id='{$_SESSION['user_id']}' and feed_users.read_notread=1
    and views>=1 and news.category_id = category.category_id GROUP BY category ORDER BY SUM(views) DESC LIMIT 12 ");//блок с категориями
  
  if($result_cat = $db->query($sql_cat)) 
  {
      if($result_cat->num_rows >= 0) 
      {
  while($row_cat = $result_cat->fetch_array())
  {
      echo"
    <a class='dropdown-item' href='../index.php?cat_id={$row_cat['category_id']}'>{$row_cat['category']}</a>
      ";
  }
  $result_cat->free();
      }
  }
            
 echo" </div>
          </li>
          <li class='nav-item'>
          <a class='nav-link' href='../index.php?feed'>Ваши подписки ".$_SESSION['login']."</a>
        </li>
       
      </ul>
      <ul class='navbar-nav justify-content-end'>
  ";
      if ((!empty($_SESSION['status']))&&($_SESSION['status'] == 1))
        {
     echo"
     <li class='nav-item'>
     <a class='nav-link' href='../index.php?admin'>admin</a>
   </li>";
       }
       echo"
       <li class='nav-item'>
       <a class='nav-link' href='../index.php?logout'>выйти</a>
       </li>
  </ul>";

      if (isset($_GET['logout']))
  {
      session_destroy();
      echo'<meta http-equiv="refresh" content="0; url=index.php"> ';
  }
  }
  
  
  
  else 
  {
$sql_cat=("SELECT category.category_id,category.category FROM category,news	
            WHERE views>=1 and news.category_id = category.category_id GROUP BY category ORDER BY SUM(views) DESC LIMIT 12 ");//блок с категориями
     
  if($result_cat = $db->query($sql_cat)) 
  {
      if($result_cat->num_rows >= 0) 
      {
  while($row_cat = $result_cat->fetch_array())
  {
      echo"
    <a class='dropdown-item' href='../index.php?cat_id={$row_cat['category_id']}'>{$row_cat['category']}</a>
      ";
  }
  $result_cat->free();
      }
  }
            
 echo" </div>
          </li>
         
       
      </ul>

      <ul class='navbar-nav justify-content-end'>
  <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='dropdown2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Вход/Регистрация</a>
        <div class='dropdown-menu'>
    <form class='px-4 py-3' action='../index.php?auth_script' method='post'>
      <div class='form-group'>
        <label for='exampleDropdownFormEmail1'>Логин</label>
        <input   name='login' class='form-control' id='exampleDropdownFormEmail1' placeholder='Введите логин' required>
      </div>
      <div class='form-group'>
        <label for='exampleDropdownFormPassword1'>Пароль</label>
        <input type='password' name='password'  class='form-control' id='exampleDropdownFormPassword1' placeholder='Введите пароль' required>
      </div>
      
      <button type='submit'  class='btn btn-primary'>Войти</button>
    </form>
    <div class='dropdown-divider'></div>
    <a class='dropdown-item' href='../index.php?reg'>Зарегистрироваться</a>
  </div>
      </li>
  </ul>";
  }



  
  if ((!empty($_SESSION['status']))&&($_SESSION['status'] == 1))
  {

  
    echo'<form class="form-inline my-2 my-md-0" method="get" action="index.php?admin&admin_search">';
  }
  else
  {
    echo '<form class="form-inline my-2 my-md-0" method="get" action="index.php?search">';
  }
?>
  <input class="form-control" type="text" name="search" placeholder="Поиск...">
  </form>
</div>
</nav><br/>
<script src='../JavaScript/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
<script src='../JavaScript/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
<script src='../styles/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script>
<script src='../JavaScript/jquery.min.js'></script>