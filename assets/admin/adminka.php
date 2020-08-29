<?php
if((!empty($_SESSION['status']))&&($_SESSION['status'] == 1))
{
echo'

<div class="mt-5 container-fluid">
          <div class="row">
            <nav class="col-md-2  d-md-block bg-light sidebar">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" href="../index.php?admin=adminka">
                      <span data-feather="home"></span>
                      Статистика <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../index.php?admin=source">
                      <span data-feather="file"></span>
                     Источники
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../index.php?admin=news">
                      <span data-feather="bar-chart-2"></span>
                      Новости
                    </a>
                  </li>
                 
                </ul>   
              </div>
            </nav>';




switch ($_GET['admin']):
    case 'adminka':
    include 'admin_stat.php';
        break;
    case 'source':
       include 'admin_add_source.php';
        break;
    case 'news':
    include 'admin_news.php';
        break;
    default:
    include 'admin_stat.php';
    endswitch;


  }
?>
 
 

 <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>

        <script src="/styles/dashboard/dashboard.js"></script></body>

      