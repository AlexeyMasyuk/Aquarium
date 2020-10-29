<?php
require_once('dbClass.php');
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}
$sql=new dbClass($user);
$entry=$sql->chartQuery($user->getUserName());
?> 
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});

	

	function change(wantedValue){

    google.setOnLoadCallback(drawChart);
    function drawChart() {

        var dataTemp = google.visualization.arrayToDataTable([
        ['time',	wantedValue],
        <?php echo $entry['temp']?>
        ]);
	    var dataPH = google.visualization.arrayToDataTable([
        ['time',	wantedValue],
        <?php echo $entry['PH']?>
        ]);
        var dataLevel = google.visualization.arrayToDataTable([
        ['time',	wantedValue],
        <?php echo $entry['level']?>
        ]);

        var options = {
            title: 'Aquarium',
            curveType: 'function',
            legend: { position: 'bottom' }
        };



        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		if (wantedValue == 'PH') {
        var data = dataPH;
        }
        else if (wantedValue == 'temp') {
        var data = dataTemp;
        }
        else if (wantedValue == 'level') {
        var data = dataLevel;
        }
        chart.draw(data, options);
    }
	}
</script>