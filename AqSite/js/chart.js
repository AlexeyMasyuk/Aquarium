function change(){
    var oReq = new XMLHttpRequest(); // New request object
    oReq.onload = function() {
        
        google.load("visualization", "1", {packages:["corechart"]});
        var arr = this.responseText.split('"');
        
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var wantedChart = document.getElementById('chart').value;

            function strToTableArr(arr){
                var newArr=arr.split(",");

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'time');
                data.addColumn('number', wantedChart);
                for(i = 0; i < newArr.length-1; i++)
                {
                    data.addRow([newArr[i], parseFloat(newArr[++i])]);
                }
                return data;
            }

            var options = {
                title: 'Aquarium',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            if (wantedChart == 'PH') {
                var data = strToTableArr(arr[7]);
            }
            else if (wantedChart == 'temp') {
                var data = strToTableArr(arr[3]);
            }
            else if (wantedChart == 'level') {
                var data = strToTableArr(arr[11]);
            }
            chart.draw(data, options);
        }

        var toDiv = document.getElementById('alarms_div');
        var alarmData = arr[15];

        toDiv.innerHTML = alarmData;

    };
    oReq.open("get", "js/chartData.php", true);
    oReq.send();
}