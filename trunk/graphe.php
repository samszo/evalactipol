<?php

if(isset($_GET['id']))
		{$id = $_GET['id'];}
		$numDepartement = substr($id,12);
		

?>
<html>
	<head>
		<script type='text/javascript' src='http://www.google.com/jsapi'></script>

		<script type="application/x-javascript" src="library/js/interface.js"></script>
		<script type="application/x-javascript" src="library/js/ajax.js"></script>
		<script type="application/x-javascript" src="library/js/tree.js"></script>

		<script type='text/javascript'>

			google.load('visualization', '1', {'packages':['motionchart']});
			google.setOnLoadCallback(drawChart);

			function drawChart() 
			{	numDepartement = "<?php echo $numDepartement; ?>";
				//response = GetData(<?php echo $id; ?>);
				response = GetDataOneDepart(numDepartement);
				eval(response);
				var chart = new google.visualization.MotionChart(document.getElementById('chart_div'));
				chart.draw(data, {width: 450, height:550});
			}		

					    
		</script>
	</head>

	<body>
		<div id='chart_div' style='width: 450px; height: 550px;'></div>
	</body>
</html>
