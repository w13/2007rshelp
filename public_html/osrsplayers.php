<?php

$mysqli = new mysqli('localhost', 'rsc_online', 'killher', 'rsc_online');

?>
<!DOCTYPE html>
<html>
  <head>
  
  <title>RuneScape OSRS Online Players</title>
  <link rel="shortcut icon" href="favicon.ico" />

	<style>
		.blockq {
			background: #f9f9f9;
			border-left: 10px solid #ccc;
			margin: 1.5em 10px;
			  margin-left: auto;
			margin-right: auto;
			padding: 0.5em 10px;
			font-size:0.9em;text-align:center;
			width:50%;
			border: 2px solid;
			border-bottom-color: #535353;
			border-right-color: #535353;
			border-left-color: #dbdbdb;
			border-top-color: #dbdbdb;
			background-color: #bfbfbf;
			max-width: 600px;
			font-size: 13px;
			padding: 2px;
			-webkit-box-shadow: 4px 4px 13px 0px rgba(66,66,66,0.71);
			-moz-box-shadow: 4px 4px 13px 0px rgba(66,66,66,0.71);
			box-shadow: 4px 4px 13px 0px rgba(66,66,66,0.71);
		}

		.contdiv{
			border: 2px solid;
			border-bottom-color: #c7c7c7;
			border-right-color: #c7c7c7;
			border-left-color: #808080;
			border-top-color: #808080;
			background-color: #fff;
			padding: 10px;
		}
	</style>
  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type='text/javascript'>
      google.charts.load('current', {'packages':['annotationchart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Players online');
      
		data.addRows([

<?php
		$lasttime = 0;
		$lastplayers = 0;
		$query = 'SELECT * FROM `osrs` ORDER BY `time` DESC LIMIT 1000';
		if ($result = $mysqli->query($query)) {
			$i = 0;
			while ($row = $result->fetch_assoc()) {			
				if($i!=0){ echo ','; } $i++; /* just so we can put the comma properly in JS */		
				echo '[new Date('.$row['time'].'000), '.$row['players'].']';
				$lasttime = $row['time'];
				$lastplayers = $row['players'];
			}
		}
		?>
        ]);

        var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div'));

        var options = {
          displayAnnotations: true
        };

        chart.draw(data, options);
      }
    </script>

</head>

<body style="background-color:#008080;">

<blockquote class="blockq" style="width:100%;max-width:1200px">
	<div class="contdiv">
		<div id='chart_div' style='width: 100%; height: 500px;'></div>
	</div>
</blockquote>
	
<blockquote class="blockq">
  <div class="contdiv">	
		<h1>OSRS Online Players: <?php echo number_format($lastplayers);?></h1>
		
		<p>Last player-count update was <?php echo intval( (time()-$lasttime)/60 ); ?> min ago. Total data points: <?php echo mysqli_num_rows($result); ?>.
		<br />
		This data has been updated hourly since 20 September 2018.</p>
		<p>For more information, see <a href="https://runescapecommunity.com">RuneScape Community</a>.</p>
	</div>
</blockquote>
	

<blockquote class="blockq" style="width:80%;max-width:900px">
	<div class="contdiv">
		<h1>Historic Data</h1>
		<p><img src="img/historicplayersonline.png" style="width: 100%;height: auto;"></p>
		<p>This is a screenshot from <a href="http://www.misplaceditems.com/rs_tools/graph/">MisplacedItems's website</a>, which also tracks player activity.</p>
	</div>
</blockquote>

<blockquote class="blockq" style="width:80%;max-width:900px">
	<div class="contdiv">
		<h1>Google Popularity Data for "RuneScape"</h1>
	<p>
		<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1544_RC05/embed_loader.js"></script> <script type="text/javascript"> trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"runescape","geo":"US","time":"2004-01-01 <?php echo date('Y-m-d'); ?>"}],"category":0,"property":""}, {"exploreQuery":"date=all&geo=US&q=runescape","guestPath":"https://trends.google.com:443/trends/embed/"}); </script>
	</p>

	
	</div>
</blockquote>
	
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-239988-18"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-239988-18');
</script>

	</body>
</html>
