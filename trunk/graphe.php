<?php

if(isset($_GET['id']))
		{$id = $_GET['id'];}
		$numDepartement = substr($id,12);
		

?>
<html>
	<head>
	
		
		<script type="text/javascript" src="./../jsunit/app/jsUnitCore.js"></script>
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
				//chart.draw(data, {width: 520, height:580});
				chart.draw(data, {width: 500, height:281});
			}

			function testdrawChart() 
			{	
				//assertTrue(true);
				assertEquals("01", numDepartement);

			}

					    
		</script>
	</head>

	<body>
		<div id='chart_div' style='width: 500px; height: 281px;'></div>
	</body>
</html>
