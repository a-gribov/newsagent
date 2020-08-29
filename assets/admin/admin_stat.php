<?php

$title='NewsAgent | Статистика';
 ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<main role="main" class="col-md-9 col-lg-10 ">
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
       Статистические данные  новостей по месяцам
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show"  aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="col-md-12">
      <div  id="chart1" style="height: 300px;"></div>
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
        <div  id="chart2" style="height: 300px;"></div>
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
    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
    <div class="col-md-12">
        <div id='chart3' style="height: 300px;"></div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        Статистические данные 
        </button>
      </h5>
    </div>
    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionExample">
    <div class="col-md-12">
        <div id='chart4' style="height: 300px;"></div>
      </div>
    </div>
  </div>
</div>
</main>





<?php
// 1

$e1=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-01' "); $e1 = $e1->fetch_assoc();
$e2=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-02' ");$e2 = $e2->fetch_assoc();
$e3=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-03' "); $e3 = $e3->fetch_assoc();
$e4=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-04' "); $e4 = $e4->fetch_assoc();
$e5=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-05' "); $e5 = $e5->fetch_assoc();
$e6=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-06' "); $e6 = $e6->fetch_assoc();
$e7=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-07' "); $e7=$e7->fetch_assoc();
$e8=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-08' "); $e8 = $e8->fetch_assoc();
$e9=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-09' "); $e9 = $e9->fetch_assoc();
$e10=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-10' "); $e10=$e10->fetch_assoc();
$e11=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-11' "); $e11=$e11->fetch_assoc();
$e12=$db->query("SELECT  COUNT(1) AS count FROM news WHERE DATE_FORMAT(date,'%Y-%m') ='2019-12' "); $e12=$e12->fetch_assoc();
?>
<script>
var e1 = '<?php echo $e1['count'];?>';
var e2 = '<?php echo $e2['count'];?>';
var e3 = '<?php echo $e3['count'];?>';
var e4 = '<?php echo $e4['count'];?>';
var e5 = '<?php echo $e5['count'];?>';
var e6 = '<?php echo $e6['count'];?>';
var e7 = '<?php echo $e7['count'];?>';
var e8 = '<?php echo $e8['count'];?>';
var e9 = '<?php echo $e9['count'];?>';
var e10 = '<?php echo $e10['count'];?>';
var e11 = '<?php echo $e11['count'];?>';
var e12 = '<?php echo $e12['count'];?>';

new Morris.Line({
  element: 'chart1',
  data: [
    { month: '2019-01', value: e1 },
    { month: '2019-02', value: e2 },
    { month: '2019-03', value: e3 },
    { month: '2019-04', value: e4 },
    { month: '2019-05', value: e5 },
    { month: '2019-06', value: e6 },
    { month: '2019-07', value: e7 },
    { month: '2019-08', value: e8 },
    { month: '2019-09', value: e9 },
    { month: '2019-10', value: e10 },
    { month: '2019-11', value: e11 },
    { month: '2019-12', value: e12 }
  ],
  xkey: 'month',
  xLabelAngle: 20,
  ykeys: ['value'],
   labels: ['новостей']
});
</script>

<script>


new Morris.Donut({
      element: 'chart2',
      data: [
        {value: 70, label: 'foo'},
        {value: 15, label: 'bar'},
        {value: 10, label: 'baz'},
        {value: 5, label: 'A really really long label'}
      ],
      formatter: function (x) { return x + "%"}
    }).on('click', function(i, row){
      console.log(i, row);
    });
</script>


<script>

 new Morris.Donut({
      element: 'chart3',
      data: [
        {value: 70, label: 'foo'},
        {value: 15, label: 'bar'},
        {value: 10, label: 'baz'},
        {value: 5, label: 'A really really long label'}
      ],
      formatter: function (x) { return x + "%"}
    }).on('click', function(i, row){
      console.log(i, row);
    });
</script>

<script>

 new Morris.Donut({
      element: 'chart4',
      data: [
        {value: 70, label: 'foo'},
        {value: 15, label: 'bar'},
        {value: 10, label: 'baz'},
        {value: 5, label: 'A really really long label'}
      ],
      formatter: function (x) { return x + "%"}
    }).on('click', function(i, row){
      console.log(i, row);
    });
</script>
