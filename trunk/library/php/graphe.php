<?php
//$id = "02";

//function GetGraphe($id){
//return $id;
//}
if(isset($_GET['id']))
		{$id = $_GET['id'];}
		$numDepartement = substr($id,12);
		

?>
<html>
	<head>
		<script type='text/javascript' src='http://www.google.com/jsapi'></script>

		<script type="application/x-javascript" src="../js/interface.js"></script>
		<script type="application/x-javascript" src="../js/ajax.js"></script>
		<script type="application/x-javascript" src="../js/tree.js"></script>

		<script type='text/javascript'>

			google.load('visualization', '1', {'packages':['motionchart']});
			google.setOnLoadCallback(drawChart);

			function drawChart() 
			{	numDepartement = "<?php echo $numDepartement; ?>";
				//response = GetData(<?php echo $id; ?>);
				response = GetDataOneDepart(numDepartement);
				eval(response);
				var chart = new google.visualization.MotionChart(document.getElementById('chart_div'));
				chart.draw(data, {width: 800, height:300});
			}		

					    
		</script>
	</head>

	<body>
		<div id='chart_div' style='width: 1200px; height: 300px;'></div>
	</body>
</html>
