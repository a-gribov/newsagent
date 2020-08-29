<?php
include 'session.php';
include 'header.php';
include 'connection.php';
$title='NewsAgent | Статистика';
 
	
		function get_views($src)
		{
			require 'connection.php';
			$sql_2=("SELECT SUM(views) AS views_sum FROM news WHERE source='$src' ");	
	$result_2 = $db->query($sql_2);
		$row_2 = $result_2->fetch_assoc();
			$source=$src;
			$views=$row_2['views_sum'];
			echo $views;
		}	
	
?>
<title><?=$title?></title>
<script  type="text/javascript">

var v1='<?php $src='dp.ru'; get_views($src);?>';
var ss1='<?php echo $src;?>';
	
var v2='<?php $src='Лента'; get_views($src);?>';
var s2='<?php echo $src;?>';
	
var v3='<?php $src='e-news'; get_views($src);?>';
var s3='<?php echo $src;?>';

var v4='<?php $src='Банки'; get_views($src);?>';
var s4='<?php echo $src;?>';

var v5='<?php $src='Фонтанка'; get_views($src);?>';
var s5='<?php echo $src;?>';
	
var v6='<?php $src='Сейчас'; get_views($src);?>';
var s6='<?php echo $src;?>';
	
var v7='<?php $src='Взгляд'; get_views($src);?>';
var s7='<?php echo $src;?>';
	
var v8='<?php $src='Ведомости'; get_views($src);?>';
var s8='<?php echo $src;?>';

var v9='<?php $src='ИноСМИ'; get_views($src);?>';
var s9='<?php echo $src;?>';

var v10='<?php $src='Рамблер'; get_views($src);?>';
var s10='<?php echo $src;?>';
	
var v11='<?php $src='Вести'; get_views($src);?>';
var s11='<?php echo $src;?>';
	
var v12='<?php $src='Ростов'; get_views($src);?>';
var s12='<?php echo $src;?>';
	
var v13='<?php $src='Русская линия'; get_views($src);?>';
var s13='<?php echo $src;?>';
	
var v14='<?php $src='metronews'; get_views($src);?>';
var s14='<?php echo $src;?>';
	
var v15='<?php $src='Эксперт'; get_views($src);?>';
var s15='<?php echo $src;?>';
	
var v16='<?php $src='NEWSru'; get_views($src);?>';
var s16='<?php echo $src;?>';
	
var v17='<?php $src='Радио Свобода'; get_views($src);?>';
var s17='<?php echo $src;?>';
	
var v18='<?php $src='Газета'; get_views($src);?>';
var s18='<?php echo $src;?>';

  $(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [v1,v2, v3, v4, v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18];
        var ticks = [ss1,s2,s3,s4,s5,s6,s7,s8,s9,s10,s11,s12,s13,s14,s15,s16,s17,s18];
         
        plot1 = $.jqplot('grafik_1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true },
				
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks,
                    tickOptions: {
                      angle: -30,
                      fontSize: '8pt'
                    }
					
			
                }
            },
            highlighter: { show: true }
        });
    });
</script>		
	








<!--2-->
	<?php
		function get_articles($src)
		{
			require 'connection.php';
			$sql=("SELECT COUNT(*) AS articles_sum FROM news WHERE source='$src' ");	
	$result = $db->query($sql);
		$row = $result->fetch_assoc();
			$views=$row['articles_sum'];
			echo $views;
		}	
$src='dp.ru'; get_articles($src);
echo $src;
?>

<script  type="text/javascript">

var vd1=<?php $src='dp.ru'; get_articles($src);?>;
var sd1='<?php echo $src;?>';
	
var vd2=<?php $src='Лента'; get_articles($src);?>;
var sd2='<?php echo $src;?>';
	
var vd3=<?php $src='e-news'; get_articles($src);?>;
var sd3='<?php echo $src;?>';

var vd4=<?php $src='Банки'; get_articles($src);?>;
var sd4='<?php echo $src;?>';

var vd5=<?php $src='Фонтанка'; get_articles($src);?>;
var sd5='<?php echo $src;?>';
	
var vd6=<?php $src='Сейчас'; get_articles($src);?>;
var sd6='<?php echo $src;?>';
	
var vd7=<?php $src='Взгляд'; get_articles($src);?>;
var sd7='<?php echo $src;?>';
	
var vd8=<?php $src='Ведомости'; get_articles($src);?>;
var sd8='<?php echo $src;?>';

var vd9=<?php $src='ИноСМИ'; get_articles($src);?>;
var sd9='<?php echo $src;?>';

var vd10=<?php $src='Рамблер'; get_articles($src);?>;
var sd10='<?php echo $src;?>';
	
var vd11=<?php $src='Вести'; get_articles($src);?>;
var sd11='<?php echo $src;?>';
	
var vd12=<?php $src='Ростов'; get_articles($src);?>;
var sd12='<?php echo $src;?>';
	
var vd13=<?php $src='Русская линия'; get_articles($src);?>;
var sd13='<?php echo $src;?>';
	
var vd14=<?php $src='metronews'; get_articles($src);?>;
var sd14='<?php echo $src;?>';
	
var vd15=<?php $src='Эксперт'; get_articles($src);?>;
var sd15='<?php echo $src;?>';
	
var vd16=<?php $src='NEWSru'; get_articles($src);?>;
var sd16='<?php echo $src;?>';
	
var vd17=<?php $src='Радио Свобода'; get_articles($src);?>;
var sd17='<?php echo $src;?>';
	
var vd18=<?php $src='Газета'; get_articles($src);?>;
var sd18='<?php echo $src;?>';


//        var d1 = [vd1,vd2, vd3, vd4, vd5,vd6,vd7,vd8,vd9,vd10,vd11,vd12,vd13,vd14,vd15,vd16,vd17,vd18];
//        var dicks = [sd1,sd2,sd3,sd4,sd5,sd6,sd7,sd8,sd9,sd10,sd11,sd12,sd13,sd14,sd15,sd16,sd17,sd18];
    

$(document).ready(function(){
    var plot1 = $.jqplot('grafik_2', [[[sd1,vd1],[sd2,vd2],[sd3,vd3],[sd4,vd4],[sd5,vd5],[sd6,vd6],[sd7,vd7],
									   [sd8,vd8],[sd9,vd9],[sd10,vd10],[sd11,vd11],[sd12,vd12],[sd13,vd13],[sd14,vd14],
									  [sd15,vd15],[sd16,vd16],[sd17,vd17],[sd18,vd18]]], {
        gridPadding: {top:0, bottom:38, left:0, right:0},
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer, 
            trendline:{ show:false }, 
            rendererOptions: { padding: 4, showDataLabels: true }
        },
        legend:{
            show:true, 
            placement: 'outside', 
            rendererOptions: {
                numberRows:17,
            }, 
            location:'wn',
            marginTop: '5px',
        }       
    });
});
</script>	



<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
       Статистические данные просмотров новостей по источникам
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show"  aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="col-md-12">
        <div id='grafik_1'></div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Статистические данные количества новостей по источникам
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="col-md-12">
        <div id='grafik_2'></div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Статистические данные 
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
